<?php

namespace App\Console\Commands;

use App\Contracts\IPaymentSystemService;
use App\Core\EntityManagerFresher;
use App\Entities\Subscription;
use App\Entities\SubscriptionCharge;
use App\Exceptions\DtoException;
use Carbon\Carbon;
use Doctrine\Common\Collections\Criteria;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;

class RenewSubscription extends Command
{
    use EntityManagerFresher;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:renew';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily renew subscriptions';

    /**
     * Execute the console command.
     *
     * @param IPaymentSystemService $paymentService
     *
     * @return int
     *
     * @throws BindingResolutionException
     * @throws DtoException
     */
    public function handle(IPaymentSystemService $paymentService): int
    {
        $em = $this->getEntityManager();
        $criteria = Criteria::create();
        $criteria->where(Criteria::expr()->isNull(Subscription::CANCEL_DATE))
            ->andWhere(Criteria::expr()->eq(Subscription::ACTIVE, 1))
            ->andWhere(Criteria::expr()->eq(Subscription::NEXT_DUE_DATE, Carbon::now()->startOfDay()->format('Y-m-d')));

        /* @var Subscription $subscriptions */
        $subscriptions = $em->getRepository(Subscription::class)->matching($criteria);
        foreach ($subscriptions as $subscription) {
            $paymentLog = new SubscriptionCharge($subscription, $subscription->getPrice(), $subscription->getVat());
            $this->getEntityManager()->persist($paymentLog);
            $this->getEntityManager()->flush();

            $data = $paymentService->subscribeRecurring($paymentLog);

            $paymentLog->setExternalId((string)$data->externalId);
            $paymentLog->setStatus($data->status);
            $this->getEntityManager()->persist($paymentLog);
            $this->getEntityManager()->flush();
        }

        return 0;
    }
}
