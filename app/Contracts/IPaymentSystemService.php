<?php

namespace App\Contracts;

use App\Dto\SubscriptionData;
use App\Entities\Subscription;
use App\Entities\SubscriptionCharge;
use App\Exceptions\DtoException;
use App\Exceptions\PaymentServiceException;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Contract for Payment System Handler.
 */
interface IPaymentSystemService
{
    /**
     * @param Subscription $subscription
     * @param bool $autoCharge
     *
     * @return SubscriptionData
     *
     * @throws DtoException
     * @throws PaymentServiceException
     */
    public function subscribe(Subscription $subscription, bool $autoCharge = true): SubscriptionData;

    /**
     * @param SubscriptionCharge $subscriptionCharge
     *
     * @return SubscriptionData
     *
     * @throws BindingResolutionException
     * @throws DtoException
     */
    public function subscribeRecurring(SubscriptionCharge $subscriptionCharge): SubscriptionData;

    /**
     * @param Subscription $subscription
     *
     * @throws DtoException
     * @throws PaymentServiceException
     */
    public function terminate(Subscription $subscription): void;
}
