<?php

namespace App\Http\Controllers;

use App\Contracts\IAccountingSystem;
use App\Core\EntityManagerFresher;
use App\Entities\Currency;
use App\Entities\Order;
use App\Entities\OrderSubscription;
use App\Entities\Product;
use App\Entities\Subscription;
use App\Entities\SubscriptionCharge;
use App\Entities\User;
use App\Enums\SubscriptionTypes;
use App\Exceptions\DtoException;
use App\Exceptions\PaymentServiceException;
use App\Services\PaymentServices\QuickPayPaymentServiceService;
use Carbon\Carbon;
use DateTime;
use Doctrine\Common\Collections\Criteria;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use NumberFormatter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserSectionController extends BaseWebController
{
    use EntityManagerFresher;

    public function dashboard(): View
    {
        //TODO: move this to a service layer
        /* @var User $user */
        $user = $this->user;

        $fmt = numfmt_create('en_US', NumberFormatter::DECIMAL);
        return view('app.dashboard', [
            'res_num_prices' => 0,
            'required_num' => 10,
            'avg_price' => 0,
            'currency_code' => 0,
            'res_user_currency' => 0,
            'res_link_avg_prices' => 0,
            'res_amount_valuta' => 0,
            'res_vanished_count' => 0,
            'res_header_nofollow_count' => 0,
            'res_rel_nofollow_count' => 0,
            'res_no_index' => 0,
            'res_all_links' => 0,
            'res_all_ok' => 0,
            'res_html_links' => 0,
            'res_js_links' => 0,
            'res_vanished_todo' => 0,
            'res_noindex_todo' => 0,
            'res_noheader_todo' => 0,
            'res_nofollow_todo' => 0,
            'fmt' => $fmt,
        ]);
    }

    public function links(): View
    {
        return view('app.links');
    }

    public function domains(): View
    {
        return view('app.domains');
    }

    /**
     * User profile page.
     *
     * @param Request $request Request Data
     *
     * @return View
     *
     * @throws BindingResolutionException
     * @throws ValidationException
     */
    public function myAccount(Request $request): View
    {
        $data = [];
        $rules = array_merge($this->user->getValidationRules(), [
            'id_valuta_display' => ['integer'],
        ]);
        $validator = Validator::make($request->all(), $rules);

        if ($request->getMethod() === 'POST') {
            if (!$validator->fails()) {
                $user = $this->user;
                $data = $validator->validated();
                if (isset($data['username'])) {
                    $user->setUsername($data['username']);
                }
                if (isset($data['firstname'])) {
                    $user->setFirstname($data['firstname']);
                }
                if (isset($data['lastname'])) {
                    $user->setLastname($data['lastname']);
                }
                if (isset($data['company'])) {
                    $user->setCompany($data['company']);
                }
                if (isset($data['vat_number'])) {
                    $user->setVatNumber($data['vat_number']);
                }
                if (isset($data['vat_valid'])) {
                    $user->setVatValid($data['vat_valid']);
                }
                if (isset($data['city'])) {
                    $user->setCity($data['city']);
                }
                if (isset($data['country'])) {
                    $user->setLang($data['country']);
                }
                if (isset($data['address'])) {
                    $user->setAddress($data['address']);
                }
                if (isset($data['email'])) {
                    $user->setEmail($data['email']);
                }
                if (isset($data['id_valuta_display'])) {
                    $user->setIdValutaDisplay($data['id_valuta_display']);
                }

                $this->getEntityManager()->persist($user);
                $this->getEntityManager()->flush();
            }
        }

        return view('app.my_account', [
            'user' => $this->user,
            'formData' => $request->all(),
            'formSubmitted' => !empty($data),
            'validationErrors' => !empty($data) && $validator->errors() ? $validator->errors()->all() : [],
            'currencies' => $this->getRepository(Currency::class)->findAll(),
        ]);
    }

    /**
     * Invoices list page.
     *
     * @return View
     */
    public function invoices(): View
    {
        $criteria = Criteria::create()
            ->orderBy([Order::ID => 'asc'])
            ->where(Criteria::expr()->eq(SubscriptionCharge::USER, $this->user));
        $invoices = $this->getRepository(SubscriptionCharge::class)->matching($criteria);

        return view('app.invoices', ['invoices' => $invoices]);
    }

    /**
     * Download invoice.
     *
     * @param string $guid Invoice Id
     * @param IAccountingSystem $accountingService Dinero
     *
     * @return Response
     */
    public function invoiceDetails(string $guid, IAccountingSystem $accountingService): Response
    {
        return new Response($accountingService->getInvoice($guid), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment;filename=faktura.pdf'
        ]);
    }

    /**
     * Plan details page.
     *
     * @return View
     */
    public function myPlan(): View
    {
        /* @var Subscription $currentSubscription */
        $currentSubscription = $this->getRepository(Subscription::class)->matching(Criteria::create()
            ->where(Criteria::expr()->eq(Subscription::CREATED_BY, $this->user))
            ->andWhere(Criteria::expr()->isNull(Subscription::CANCEL_DATE))
            ->andWhere(Criteria::expr()->lt(Subscription::NEXT_DUE_DATE, (new DateTime())))
            ->andWhere(Criteria::expr()->eq(Subscription::ACTIVE, true))
        )->get(0);

        return view('app.my_plan', [
            'plan' => $currentSubscription ? $currentSubscription->getProduct() : null,
            'subscription' => $currentSubscription,
            'user' => $this->user,
            'plans' => $this->getRepository(Product::class)->matching(Criteria::create()
                ->orderBy(['pricePerMonth' => 'asc'])
                ->where(Criteria::expr()->eq('public', 1))),
            'isPaymentCanceled' => false,
        ]);
    }

    public function cancelPlan(): View
    {
//        $orders = new Orders($db);
//        $users = new Users($db);
//        $user = $users->get_user($session->id);
//        if ($user['subscription_id'] == 0) {
//            $functions->updateUserByid($session->id, 'renew', 0);
//            $functions->updateUserByid($session->id, 'sub_id', '');
//            $functions->updateUserByid($session->id, 'sub_table_id', 0);
//        }
//        else {
//            $cancel = $orders->cancel_subscription($user['subscription_id'], $functions);
//            if ($cancel['curl_info']['http_code'] == '202' || $cancel['curl_info']['http_code'] == '400') {
//                $confirm = 'Subscription Canceled';
//                $functions->updateUserByid($session->id, 'renew', 0);
//                $functions->updateUserByid($session->id, 'sub_id', '');
//                $functions->updateUserByid($session->id, 'sub_table_id', 0);
//            }
//            else {
//                $error = '<p>And Error has happend</p>';
//            }
//        }

        return view('app.my_plan', ['plan' => $this->user->getPlan(), 'isPaymentCanceled' => true]);
    }

    /**
     * @param string $mixId
     * @param string $type
     *
     * @return View
     */
    public function changePlan(string $mixId, string $type): View
    {
        /* @var Product $plan */
        $plan = $this->getRepository(Product::class)->findOneBy(['mixId' => $mixId]);
        if (!$plan) {
            throw new NotFoundHttpException();
        }

        $price = ($type === SubscriptionTypes::MONTHLY ? $plan->getPricePerMonth() : $plan->getPricePeriod()) / 100;
        $vatValue = 0;
        if ($this->user->getVatValid() === 'DK') {
            $vatValue = 0.25;
        }

        return view('app.change_plan', [
            'plan' => $plan,
            'type' => $type,
            'user' => $this->user,
            'nextDueDate' => Carbon::now()
                ->subMonths($this->user->getOldUser() !== 1 ? $plan->getFreeTrail() : 0)
                ->format('Y-m-d'),
            'price' => round($price, 2),
            'vat' => round($price * $vatValue, 2),
            'total' => round($price + $price * $vatValue, 2),
        ]);
    }
    /**
     * @param string $subscription
     *
     * @return View
     *
     * @throws BindingResolutionException
     */
    public function terminateSubscription(string $subscription): View
    {
        /* @var OrderSubscription $subscription */
        $subscription = $this->getRepository(Subscription::class)->findOneBy(['id' => $subscription]);
        if (!$subscription) {
            throw new NotFoundHttpException();
        }
        $plan = $subscription->getProduct();
        $price = ($subscription->getType() === SubscriptionTypes::MONTHLY
                ? $plan->getPricePerMonth()
                : $plan->getPricePeriod()) / 100;
        $vatValue = 0;
        if ($this->user->getVatValid() === 'DK') {
            $vatValue = 0.25;
        }

        return view('app.change_plan', [
            'plan' => $subscription->getProduct(),
            'type' => $subscription->getType(),
            'user' => $this->user,
            'nextDueDate' => Carbon::now()
                ->subMonths($this->user->getOldUser() !== 1 ? $plan->getFreeTrail() : 0)
                ->format('Y-m-d'),
            'price' => round($price, 2),
            'vat' => round($price * $vatValue, 2),
            'total' => round($price + $price * $vatValue, 2),
        ]);
    }

    /**
     * @param Request $request
     * @param QuickPayPaymentServiceService $paymentService
     *
     * @return Redirector|RedirectResponse
     *
     * @throws BindingResolutionException
     * @throws DtoException
     * @throws PaymentServiceException
     */
    public function paySubscription(Request $request, QuickPayPaymentServiceService $paymentService)
    {
        if (!$request->get('type') || !$request->get('product')) {
            throw new NotFoundHttpException('Subscription not found');
        }

        /* @var Product $product */
        /* @var Subscription $subscription */
        $product = $this->getRepository(Product::class)->findOneBy(['mixId' => $request->get('product')]);
        $subscriptionPeriod = $request->get('type') === SubscriptionTypes::MONTHLY
            ? $product->getRenew()
            : $product->getRenewSubscribe();

        $subscription = new Subscription($this->user, $product, $subscriptionPeriod);
        $this->getEntityManager()->persist($subscription);
        $this->getEntityManager()->flush();
        $subscriptionData = $paymentService->subscribe($subscription);

        $subscription->fill($subscriptionData);

        $this->getEntityManager()->persist($subscription);
        $this->getEntityManager()->flush();

        return redirect($subscriptionData->paymentUrl);
    }

}
