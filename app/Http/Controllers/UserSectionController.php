<?php

namespace App\Http\Controllers;

use App\Contracts\IAccountingSystem;
use App\Core\EntityManagerFresher;
use App\Dto\BackLinks\BackLinksFilter;
use App\Dto\CursorDto;
use App\Dto\Statistics\StatisticsFilterDto;
use App\Entities\BackLink;
use App\Entities\Currency;
use App\Entities\Domain;
use App\Entities\Order;
use App\Entities\OrderSubscription;
use App\Entities\Product;
use App\Entities\Subscription;
use App\Entities\SubscriptionCharge;
use App\Entities\User;
use App\Enums\StatisticsGroupByValues;
use App\Enums\StatisticsTypes;
use App\Enums\SubscriptionTypes;
use App\Exceptions\AuthServiceException;
use App\Exceptions\DtoException;
use App\Exceptions\PaymentServiceException;
use App\Exceptions\ServiceException;
use App\Repositories\BackLinkRepository;
use App\Services\PaymentServices\QuickPayPaymentServiceService;
use App\Services\Statistics\StatisticsServicesFactory;
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
use Psr\SimpleCache\InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserSectionController extends BaseWebController
{
    use EntityManagerFresher;

    /**
     * Dashboard page.
     *
     * @param StatisticsServicesFactory $statisticsServicesFactory Services Factory
     *
     * @return View
     *
     * @throws BindingResolutionException
     * @throws DtoException
     */
    public function dashboard(StatisticsServicesFactory $statisticsServicesFactory): View
    {
        /* @var User $user */
        $user = $this->user;

        $backLinksTotal = $statisticsServicesFactory->build(StatisticsTypes::BACKLINKS)
            ->getStatistics(new StatisticsFilterDto([
                StatisticsFilterDto::USER => $user,
                StatisticsFilterDto::END => Carbon::now(),
                StatisticsFilterDto::GROUP_BY => StatisticsGroupByValues::LOST,
            ]));
        $backLinksDaily = $statisticsServicesFactory->build(StatisticsTypes::BACKLINKS)
            ->getStatistics(new StatisticsFilterDto([
                StatisticsFilterDto::USER => $user,
                StatisticsFilterDto::START => Carbon::now()->subDay(),
                StatisticsFilterDto::END => Carbon::now(),
                StatisticsFilterDto::GROUP_BY => StatisticsGroupByValues::LOST,
            ]));
        $domains = $statisticsServicesFactory->build(StatisticsTypes::DOMAINS)
            ->getStatistics(new StatisticsFilterDto([
                StatisticsFilterDto::USER => $user,
                StatisticsFilterDto::GROUP_BY => StatisticsGroupByValues::LOST,
            ]));
        $backLinksDailyGraph = $statisticsServicesFactory->build(StatisticsTypes::BACKLINKS_GRAPH)
            ->getStatistics(new StatisticsFilterDto([
                StatisticsFilterDto::USER => $user,
                StatisticsFilterDto::START => Carbon::now()->subDay(),
                StatisticsFilterDto::END => Carbon::now(),
                StatisticsFilterDto::GROUP_BY => StatisticsGroupByValues::DAYS,
            ]));

        return view('app.dashboard', [
            'backLinksTotal' => $backLinksTotal,
            'backLinksDaily' => $backLinksDaily,
            'backLinksDailyGraph' => $backLinksDailyGraph,
            'domains' => $domains,
            'user' => $user,
        ]);
    }

    /**
     * Links Page.
     *
     * @param Request $request Request
     *
     * @return View
     *
     * @throws DtoException
     */
    public function links(Request $request): View
    {
        $page = $request->get('page') ?? 1;
        $perPage = 50;
        $validated = $request->all(BackLinksFilter::getFields());
        $filter = new BackLinksFilter([
            CursorDto::LIMIT => $perPage,
            CursorDto::COUNT => ($page - 1) * $perPage,
            BackLinksFilter::USER => $this->user,
            BackLinksFilter::SEARCH => $request->get(BackLinksFilter::SEARCH),
            BackLinksFilter::DOMAIN =>
                isset($validated[BackLinksFilter::DOMAIN]) ? (int)$validated[BackLinksFilter::DOMAIN] : null,
            BackLinksFilter::REL => $request->get(BackLinksFilter::REL),
            BackLinksFilter::NOINDEX =>
                isset($validated[BackLinksFilter::NOINDEX]) ? (bool)$validated[BackLinksFilter::NOINDEX] : null,
            BackLinksFilter::FOLLOW =>
                isset($validated[BackLinksFilter::FOLLOW]) ? (bool)$validated[BackLinksFilter::FOLLOW] : null,
            BackLinksFilter::INDEXED =>
                isset($validated[BackLinksFilter::INDEXED]) ? (bool)$validated[BackLinksFilter::INDEXED] : null,
            BackLinksFilter::IS_FAILED =>
                isset($validated[BackLinksFilter::IS_FAILED]) ? (bool)$validated[BackLinksFilter::IS_FAILED] : null,
            BackLinksFilter::IS_LOST =>
                isset($validated[BackLinksFilter::IS_LOST]) ? (bool)$validated[BackLinksFilter::IS_LOST] : null,
            BackLinksFilter::IS_LIVE =>
                isset($validated[BackLinksFilter::IS_LIVE]) ? (bool)$validated[BackLinksFilter::IS_LIVE] : null,
            BackLinksFilter::SUBDOMAINS =>
                isset($validated[BackLinksFilter::SUBDOMAINS]) ? (bool)$validated[BackLinksFilter::SUBDOMAINS] : null,
            BackLinksFilter::DATE_FROM => isset($validated[BackLinksFilter::DATE_FROM])
                ? Carbon::parse($validated[BackLinksFilter::DATE_FROM])
                : null,
            BackLinksFilter::DATE_TO => isset($validated[BackLinksFilter::DATE_TO])
                ? Carbon::parse($validated[BackLinksFilter::DATE_TO])
                : null,
            BackLinksFilter::RANK_FROM =>
                isset($validated[BackLinksFilter::RANK_FROM]) ? (int)$validated[BackLinksFilter::RANK_FROM] : null,
            BackLinksFilter::RANK_TO =>
                isset($validated[BackLinksFilter::RANK_TO]) ? (int)$validated[BackLinksFilter::RANK_TO] : null,
        ]);

        /* @var BackLinkRepository $repository */
        $repository = $this->getRepository(BackLink::class);
        $countPages = ceil($repository->countLinksByFilter($filter) / $perPage);
        $links = $repository->getSections($filter);

        return view('app.links', [
            'domains' => $this->user->getDomains(),
            'links' => $links,
            'user' => $this->user,
            'page' => $page,
            'of' => $countPages,
            'search' => $filter->search,
        ]);
    }

    /**
    * Contacts page.
    * 
    * @return View
    */
    public function contacts(): View
    {
        return view('app.contacts');
    }

    /**
     * Domains page.
     *
     * @param Request $request Request
     *
     * @return View
     */
    public function domains(Request $request): View
    {
        $page = $request->get('page') ?? 1;
        $perPage = 30;
        $search = $request->get('search');
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq(Domain::USER, $this->user))
            ->andWhere(Criteria::expr()->eq(Domain::DELETED, false));

        if ($search) {
            $criteria->andWhere(Criteria::expr()->contains(Domain::DOMAIN_URL, $search));
        }

        $countPages = ceil($this->getRepository(Domain::class)->matching($criteria)->count() / $perPage);

        $criteria->setMaxResults($perPage)->setFirstResult(($page - 1) * $perPage);
        $domains = collect($this->getRepository(Domain::class)->matching($criteria));

        return view('app.domains', [
            'domains' => $domains,
            'user' => $this->user,
            'page' => $page,
            'of' => $countPages,
            'search' => $search,
        ]);
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
                    $user->setFirstName($data['firstname']);
                }
                if (isset($data['lastname'])) {
                    $user->setLastName($data['lastname']);
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
     * @param Request $request Request
     *
     * @return View
     */
    public function invoices(Request $request): View
    {
        $page = $request->get('page') ?? 1;
        $perPage = 30;
        $search = $request->get('search');
        $criteria = Criteria::create()
            ->orderBy([Order::ID => 'asc'])
            ->where(Criteria::expr()->eq(SubscriptionCharge::USER, $this->user));

        if ($search) {
            $criteria->andWhere(Criteria::expr()->contains(SubscriptionCharge::DOMAIN_URL, $search));
        }

        $countPages = ceil($this->getRepository(SubscriptionCharge::class)->matching($criteria)->count() / $perPage);

        $criteria->setMaxResults($perPage)->setFirstResult(($page - 1) * $perPage);
        $domains = collect($this->getRepository(SubscriptionCharge::class)->matching($criteria));

        return view('app.invoices', ['invoices' => $domains, 'page' => $page, 'of' => $countPages]);
    }

    /**
     * Download invoice.
     *
     * @param string $guid Invoice Id
     * @param IAccountingSystem $accountingService Dinero
     *
     * @return Response
     *
     * @throws AuthServiceException
     * @throws ServiceException
     * @throws InvalidArgumentException
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
        $currentSubscription = $this->user->getSubscription();

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

    /**
     * @return View
     *
     * @throws BindingResolutionException
     */
    public function cancelPlan(): View
    {
        $currentSubscription = $this->user->getSubscription();
        if ($currentSubscription && !$currentSubscription->getCancelDate()) {
            $currentSubscription->setCancelDate(new DateTime());
            $this->getEntityManager()->persist($currentSubscription);
            $this->getEntityManager()->flush();
        }

        return view('app.my_plan', [
            'plan' => $currentSubscription ? $currentSubscription->getProduct() : null,
            'subscription' => $currentSubscription,
            'user' => $this->user,
            'plans' => $this->getRepository(Product::class)->matching(Criteria::create()
                ->orderBy(['pricePerMonth' => 'asc'])
                ->where(Criteria::expr()->eq('public', 1))),
            'isPaymentCanceled' => true,
        ]);
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

    /**
     * Update Credit Card Information.
     *
     * @param Subscription $subscription
     * @param QuickPayPaymentServiceService $paymentService
     *
     * @return Redirector|RedirectResponse
     *
     * @throws BindingResolutionException
     * @throws DtoException
     * @throws PaymentServiceException
     */
    public function updateSubscription(Subscription $subscription, QuickPayPaymentServiceService $paymentService)
    {
        $newSubscription = new Subscription($this->user, $subscription->getProduct(), $subscription->getPeriod());
        $newSubscription->setNextDueDate($subscription->getNextDueDate());
        $this->getEntityManager()->persist($newSubscription);
        $this->getEntityManager()->flush();

        $subscriptionData = $paymentService->subscribe($newSubscription, false);

        $newSubscription->fill($subscriptionData);

        $this->getEntityManager()->persist($newSubscription);
        $this->getEntityManager()->flush();

        return redirect($subscriptionData->paymentUrl);
    }
}
