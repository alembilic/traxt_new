<?php

namespace App\Jobs;

use App\Contracts\IPaymentSystemService;
use App\Core\EntityManagerFresher;
use App\Entities\Subscription;
use App\Exceptions\DtoException;
use App\Exceptions\PaymentServiceException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Queue\InteractsWithQueue;

class TerminateSubscriptionJob extends BaseJob implements ShouldBeUniqueUntilProcessing
{
    use EntityManagerFresher;
    use InteractsWithQueue;

    /**
     * Queue to handle this job.
     *
     * @var string
     */
    public $queue = 'default';

    private int $subscriptionId;

    /**
     * TerminateSubscriptionJob constructor.
     *
     * @param Subscription $subscription
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscriptionId = $subscription->getId();
    }

    /**
     * @param IPaymentSystemService $service
     *
     * @throws BindingResolutionException
     * @throws DtoException
     * @throws PaymentServiceException
     */
    public function handle(IPaymentSystemService $service): void
    {
        $entityManager = $this->getEntityManager();
        $subscription = $entityManager->find(Subscription::class, $this->subscriptionId);
        if (!$subscription) {
            return;
        }

        $service->terminate($subscription);
    }
}
