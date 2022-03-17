<?php

namespace App\Jobs;

use App\Contracts\IAccountingSystem;
use App\Core\EntityManagerFresher;
use App\Entities\SubscriptionCharge;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Queue\InteractsWithQueue;

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
     */
    public function handle(IAccountingSystem $service): void
    {
        $entityManager = $this->getEntityManager();
        $charge = $entityManager->find(SubscriptionCharge::class, $this->chargeId);
        if (!$charge) {
            return;
        }

        $externalId = $service->createInvoice($charge);

        $user = $charge->getSubscription()->getCreatedBy();
        $user->setDineroAddGuid();
    }
}
