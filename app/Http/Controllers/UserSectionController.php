<?php

namespace App\Http\Controllers;

use App\Core\EntityManagerFresher;
use App\Entities\Currency;
use App\Entities\Order;
use App\Entities\OrderSubscription;
use App\Entities\Product;
use App\Entities\User;
use App\Enums\SubscriptionTypes;
use App\Exceptions\AuthServiceException;
use App\Exceptions\DtoException;
use App\Exceptions\PaymentServiceException;
use App\Exceptions\ServiceException;
use App\Services\Dinero\DineroService;
use App\Services\PaymentServices\QuickPayPaymentService;
use Carbon\Carbon;
use Doctrine\Common\Collections\Criteria;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
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

//        $res = $dbc->get_all_links($session->id, $session->userinfo['plan'], $session->userinfo['active_plan']);
//        $res_all_links = count($res);
//
//        $res_header_nofollow = $dbc->get_headers_with_nofollow($session->id, $session->userinfo['plan'], $session->userinfo['active_plan']);
//        $res_header_nofollow_count = count($res_header_nofollow);
//
//        $res_rel_nofollow = $dbc->get_rel_with_nofollow($session->id, $session->userinfo['plan'], $session->userinfo['active_plan']);
//        $res_rel_nofollow_count = count($res_rel_nofollow);
//
//        $res_non_indexed = $dbc->get_non_indexed($session->id, $session->userinfo['plan'], $session->userinfo['active_plan']);
//        $res_no_index = count($res_non_indexed);
//
//        $res = $dbc->get_html_links($session->id, $session->userinfo['plan'], $session->userinfo['active_plan']);
//        $res_html_links = count($res);
//
//        $res = $dbc->get_js_links($session->id, $session->userinfo['plan'], $session->userinfo['active_plan']);
//        $res_js_links = count($res);
//
//        $res_vanished = $dbc->get_notfound($session->id, $session->userinfo['plan'], $session->userinfo['active_plan']);
//        $res_vanished_count = count($res_vanished);
//
//        $res_link_prices = $dbc->get_link_prices($session->id, $session->userinfo['plan'], $session->userinfo['active_plan']);
//        $res_link_avg_prices = $dbc->get_avg_link_prices($session->id, $session->userinfo['plan'], $session->userinfo['active_plan']);
//        $res_user_currency = $dbc->getUserDashboardCurrency($session->id)[0]['currency'];
//        $res_amount_valuta = $dbc->get_amount_in_valuta($res_user_currency);
//        $res_num_prices = count($res_link_prices);
//        $required_num = 10;
//        $currency_code = $res_amount_valuta[0]['code'];
//        if ($res_user_currency == 1) {
//            $avg_price = $res_link_avg_prices[0]['price'] / $res_amount_valuta[0]['value'];
//            $fmt = numfmt_create('da_DK', NumberFormatter::DECIMAL);
//        } else {
//            $avg_price = $res_link_avg_prices[0]['price'] / $res_amount_valuta[0]['value'] * 100;
//            $fmt = numfmt_create('en_US', NumberFormatter::DECIMAL);
//        }
//
//        $res_all_ok = $res_all_links - ($res_header_nofollow_count + $res_rel_nofollow_count + $res_no_index + $res_js_links + $res_vanished_count);
//
//        $res_vanished_todo = $dbc->get_ExternalUrlData($res_vanished);
//        $res_noindex_todo = $dbc->get_ImportedUrlData($res_non_indexed);
//        $res_noheader_todo = $dbc->get_ImportedUrlData($res_header_nofollow);
//        $res_nofollow_todo = $dbc->get_ImportedUrlData($res_rel_nofollow);
//
//        return view('app.dashboard', [
//            'res_num_prices' => $res_num_prices,
//            'required_num' => $required_num,
//            'avg_price' => $avg_price,
//            'currency_code' => $currency_code,
//            'res_user_currency' => $res_user_currency,
//            'res_link_avg_prices' => $res_link_avg_prices,
//            'res_amount_valuta' => $res_amount_valuta,
//            'res_vanished_count' => $res_vanished_count,
//            'res_header_nofollow_count' => $res_header_nofollow_count,
//            'res_rel_nofollow_count' => $res_rel_nofollow_count,
//            'res_no_index' => $res_no_index,
//            'res_all_links' => $res_all_links,
//            'res_all_ok' => $res_all_ok,
//            'res_html_links' => $res_html_links,
//            'res_js_links' => $res_js_links,
//            'res_vanished_todo' => $res_vanished_todo,
//            'res_noindex_todo' => $res_noindex_todo,
//            'res_noheader_todo' => $res_noheader_todo,
//            'res_nofollow_todo' => $res_nofollow_todo,
//            'fmt' => $fmt,
//        ]);


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
            ->where(Criteria::expr()->eq(Order::USER, $this->user));
        $invoices = $this->getRepository(Order::class)->matching($criteria);

        return view('app.invoices', ['invoices' => $invoices]);
    }

    /**
     * Download invoice.
     *
     * @param string $guid Invoice Id
     * @param DineroService $dineroService Dinero Service
     *
     * @return Response
     *
     * @throws AuthServiceException
     * @throws ServiceException
     */
    public function invoiceDetails(string $guid, DineroService $dineroService): Response
    {
        return new Response($dineroService->getInvoice($guid), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment;filename=faktura.pdf'
        ]);
    }

    /**
     * @return View
     *
     * @throws BindingResolutionException
     */
    public function myPlan(): View
    {
        $criteria = Criteria::create()
            ->orderBy(['pricePerMonth' => 'asc'])
            ->where(Criteria::expr()->eq('public', 1));

        return view('app.my_plan', [
            'plan' => $this->user->getPlan(),
            'subscription' => $this->user->getSubscription(),
            'user' => $this->user,
            'plans' => $this->getRepository(Product::class)->matching($criteria),
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
     * @param QuickPayPaymentService $paymentService
     *
     * @return View
     *
     * @throws BindingResolutionException
     * @throws DtoException
     * @throws PaymentServiceException
     */
    public function changePlan(string $mixId, string $type, QuickPayPaymentService $paymentService): View
    {
        /* @var Product $plan */
        $plan = $this->getRepository(Product::class)->findOneBy(['mixId' => $mixId]);
        if (!$plan) {
            throw new NotFoundHttpException();
        }

        $subscriptionId = Cache::get('subscriptionId');
        if (!$subscriptionId) {
            $this->user->addActiveSubscriptions(new OrderSubscription($this->user, $plan, $type));
            $this->entityManager->persist($this->user);
            $this->entityManager->flush();
            $subscription = $this->user->getSubscription();
            Cache::put('subscriptionId', $subscription->getId(), 86400);
        } else {
            $subscription = $this->getRepository(OrderSubscription::class)->findOneBy(['id' => $subscriptionId]);
        }

        $price = ($type === SubscriptionTypes::ONCE ? $plan->getPricePerMonth() : $plan->getPriceSubscription()) / 100;
        $vatValue = 0;
        if ($this->user->getVatValid() === 'DK') {
            $vatValue = 0.25;
        }

        return view('app.change_plan', [
            'plan' => $plan,
            'type' => $type,
            'user' => $this->user,
            'paymentUrl' => $paymentService->getPaymentLink($subscription),
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
     * @param QuickPayPaymentService $paymentService
     *
     * @return View
     *
     * @throws BindingResolutionException
     * @throws DtoException
     * @throws PaymentServiceException
     */
    public function terminateSubscription(string $subscription, QuickPayPaymentService $paymentService): View
    {
        /* @var OrderSubscription $subscription */
        $subscription = $this->getRepository(OrderSubscription::class)->findOneBy(['id' => $subscription]);
        if (!$subscription) {
            throw new NotFoundHttpException();
        }
        $plan = $subscription->getProduct();
        $price = ($subscription->getType() === SubscriptionTypes::ONCE
                ? $plan->getPricePerMonth()
                : $plan->getPriceSubscription()) / 100;
        $vatValue = 0;
        if ($this->user->getVatValid() === 'DK') {
            $vatValue = 0.25;
        }

        return view('app.change_plan', [
            'plan' => $subscription->getProduct(),
            'type' => $subscription->getType(),
            'user' => $this->user,
            'paymentUrl' => $paymentService->getPaymentLink($subscription),
            'nextDueDate' => Carbon::now()
                ->subMonths($this->user->getOldUser() !== 1 ? $plan->getFreeTrail() : 0)
                ->format('Y-m-d'),
            'price' => round($price, 2),
            'vat' => round($price * $vatValue, 2),
            'total' => round($price + $price * $vatValue, 2),
        ]);
    }
}
