<?php

namespace App\Services\PaymentServices;

use App\Contracts\IPaymentSystemService;
use App\Contracts\IWebhookHandler;
use App\Core\EntityManagerFresher;
use App\Dto\PaymentData;
use App\Dto\SubscriptionData;
use App\Entities\Subscription;
use App\Entities\SubscriptionCharge;
use App\Enums\ChargeStatuses;
use App\Exceptions\DtoException;
use App\Exceptions\PaymentServiceException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use QuickPay\QuickPay;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

/**
 * QuickPay Payment service
 */
class QuickPayPaymentServiceService implements IWebhookHandler, IPaymentSystemService
{
    use EntityManagerFresher;

    /**
     * @var QuickPay
     */
    private QuickPay $client;

    /**
     * @param QuickPay $client
     */
    public function __construct(QuickPay $client)
    {
        $this->client = $client;
    }

    /**
     * @param Subscription $subscription
     *
     * @return PaymentData
     *
     * @throws DtoException
     * @throws PaymentServiceException
     */
    private function createSubscription(Subscription $subscription): PaymentData
    {
        $response = $this->client->request->get('/subscriptions?order_id=sub' . $subscription->getId(), []);
        $data = $response->asArray();
        if ($data[0] ?? false) {
            return new PaymentData([
                PaymentData::STATUS => $response->httpStatus(),
                PaymentData::ID => (string)$data[0]['id'],
            ]);
        }

        $form = [
            'order_id' => 'sub' . $subscription->getId(),
            'currency' => 'usd',
            'description' => $subscription->getProduct()->getProductName(),
            'amount' => $subscription->getTotal(),
        ];
        $response = $this->client->request->post('/subscriptions', $form);
        $status = $response->httpStatus();
        $data = $response->asArray();

        if (!($data['id'] ?? false)) {
            $log = env('APP_DEBUG') ? implode(' ', $data) : '';
            throw new PaymentServiceException("Subscription [{$subscription->getId()}] was not created." . $log);
        }

        return new PaymentData([
            PaymentData::STATUS => $status,
            PaymentData::ID => (string)$data['id'],
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function subscribe(Subscription $subscription, bool $autoCharge = true): SubscriptionData
    {
        $paymentData = $this->createSubscription($subscription);
        $form = [
            'amount' => intval($subscription->getTotal() * 100),
            'callback_url' => config('app.url') . '/api/webhook/quickPay?subscription_id=' .
                $subscription->getId() . ($autoCharge ? '&autoCharge=1' : ''),
            'continue_url' => config('app.url') . '/app/dashboard?new_signup=1&id=' . $subscription->getId(),
            'cancel_url' => config('app.url') . '/app/subscription-terminate?id=' . $subscription->getId(),
        ];
        $response = $this->client->request->put('/subscriptions/' . $paymentData->getId() . '/link', $form);
        $data = $response->asArray();
        if (!($data['url'] ?? false)) {
            $log = env('APP_DEBUG') ? implode(' ', $data) : '';
            throw new PaymentServiceException("Subscription [{$subscription->getId()}] was not created." . $log);
        }

        return new SubscriptionData([
            SubscriptionData::PAYMENT_URL => $data['url'],
            SubscriptionData::EXTERNAL_ID => $paymentData->getId(),
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function subscribeRecurring(SubscriptionCharge $subscriptionCharge): SubscriptionData
    {
        $form = [
            'amount' => intval($subscriptionCharge->getTotal() * 100),
            'order_id' => 'req' . $subscriptionCharge->getId(),
            'auto_capture' => true,
        ];
        $response = $this->client->request->post(
            '/subscriptions/' . $subscriptionCharge->getSubscription()->getExternalId() . '/recurring',
            $form
        );
        $data = $response->asArray();

        return new SubscriptionData([
            SubscriptionData::EXTERNAL_ID => $data['id'],
            SubscriptionData::STATUS => $response->httpStatus() >= 300
                ? ChargeStatuses::FAIL
                : ChargeStatuses::COMPLETE,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function terminate(Subscription $subscription): void
    {
        $form = [
            'id' => $subscription->getExternalId(),
        ];
        $this->client->request->post('/subscriptions/' . $subscription->getExternalId() . '/cancel', $form);
    }

    /**
     * TODO: move this method to a separate service.
     *
     * @param Request $request
     *
     * @throws BindingResolutionException|DtoException
     */
    public function handleWebhook(Request $request): void
    {
        $subscription = $this->getEntityManager()->find(Subscription::class, $request->get('subscription_id'));
        if (!$subscription) {
            throw new BadRequestException('Subscription not found');
        }
        $autoCapture = (bool)$request->get('autoCharge');
        if ($autoCapture) {
            $paymentLog = new SubscriptionCharge($subscription, $subscription->getPrice(), $subscription->getVat());
            $this->getEntityManager()->persist($paymentLog);
            $this->getEntityManager()->flush();

            $data = $this->subscribeRecurring($paymentLog);

            $paymentLog->setExternalId($data->externalId);
            $paymentLog->setStatus($data->status);
            $this->getEntityManager()->persist($paymentLog);
            $this->getEntityManager()->flush();
        }
    }
}
