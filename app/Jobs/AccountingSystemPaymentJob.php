<?php

namespace App\Jobs;

use App\Contracts\IAccountingSystem;
use App\Core\EntityManagerFresher;
use App\Entities\SubscriptionCharge;
use App\Exceptions\AuthServiceException;
use App\Exceptions\ServiceException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Queue\InteractsWithQueue;
use Psr\SimpleCache\InvalidArgumentException;

class AccountingSystemPaymentJob extends BaseJob implements ShouldBeUniqueUntilProcessing
{
    use EntityManagerFresher;
    use InteractsWithQueue;

    /**
     * Queue to handle this job.
     *
     * @var string
     */
    public $queue = 'default';

    private int $chargeId;

    /**
     * AccountingSystemPaymentJob constructor.
     *
     * @param SubscriptionCharge $subscriptionCharge
     */
    public function __construct(SubscriptionCharge $subscriptionCharge)
    {
        $this->chargeId = $subscriptionCharge->getId();
    }

    /**
     * Executes the job.
     *
     * @param IAccountingSystem $service Accounting Service
     *
     * @throws BindingResolutionException
     * @throws AuthServiceException
     * @throws ServiceException
     * @throws InvalidArgumentException
     */
    public function handle(IAccountingSystem $service): void
    {
        /* @var SubscriptionCharge $charge */
        $entityManager = $this->getEntityManager();
        $charge = $entityManager->find(SubscriptionCharge::class, $this->chargeId);
        if (!$charge) {
            return;
        }

        $user = $charge->getCreatedBy();
        $subscription = $charge->getSubscription();

        $userGuid = $service->createUser($charge);
        $user->setDineroAddGuid($userGuid);
        $entityManager->persist($user);

        $externalId = $service->createInvoice($user, $charge);
        $charge->setAccountingSystemId($externalId);
        $subscription->setAccountingSystemId($externalId);
        $entityManager->persist($charge);
        $entityManager->persist($subscription);
        $entityManager->flush();
    }
}
