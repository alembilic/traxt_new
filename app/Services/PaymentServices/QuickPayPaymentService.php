<?php

namespace App\Services\PaymentServices;

use App\Dto\PaymentData;
use App\Entities\OrderSubscription;
use App\Exceptions\DtoException;
use App\Exceptions\PaymentServiceException;
use Illuminate\Contracts\Container\BindingResolutionException;
use QuickPay\QuickPay;

/**
 * QuickPay Payment service
 */
class QuickPayPaymentService
{
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
     * @param OrderSubscription $subscription
     *
     * @return PaymentData
     *
     * @throws PaymentServiceException
     * @throws DtoException
     * @throws BindingResolutionException
     */
    private function createSubscription(OrderSubscription $subscription): PaymentData
    {
        $form = [
            'order_id' => $subscription->getId(),
            'currency' => 'usd',
            'description' => $subscription->getProduct()->getProductName(),
            'amount' => $subscription->getTotal(),
        ];
        $response = $this->client->request->post('/subscriptions', $form);
        $status = $response->httpStatus();
        $data = $response->asArray();
        if (!($data['id'] ?? false)) {
            throw new PaymentServiceException('Subscription was not created.');
        }

        return new PaymentData([
            PaymentData::STATUS => $status,
            PaymentData::ID => $data['id'],
        ]);
    }

    /**
     * @param OrderSubscription $subscription
     *
     * @return string
     *
     * @throws BindingResolutionException
     * @throws PaymentServiceException
     * @throws DtoException
     */
    public function getPaymentLink(OrderSubscription $subscription): string
    {
        $paymentData = $this->createSubscription($subscription);
        $form = [
            'amount' => $subscription->getTotal(),
            'callback_url' =>  config('app.url') . '/api/webhook/quickPay?id=' . $subscription->getId(),
            'continue_url' => config('app.url') . '/app/dashboard?new_signup=1&id=' . $subscription->getId(),
            'cancel_url' => config('app.url') . '/app/subscription-terminate?id=' . $subscription->getId(),
        ];
        $response = $this->client->request->post('/subscriptions/' . $paymentData->getId() . '/link', $form);
        $data = $response->asArray();
        if (!($data['url'] ?? false)) {
            throw new PaymentServiceException('Subscription was not created.');
        }

        return $data['url'];
    }
}
