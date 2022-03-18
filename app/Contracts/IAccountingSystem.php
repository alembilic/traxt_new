<?php

namespace App\Contracts;

use App\Entities\SubscriptionCharge;
use App\Entities\User;
use App\Exceptions\AuthServiceException;
use App\Exceptions\ServiceException;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * Contract for Accounting System Handler.
 */
interface IAccountingSystem
{
    /**
     * Create invoice in accounting system.
     *
     * @param User $user User
     * @param SubscriptionCharge $charge Charge Operation
     *
     * @return string
     *
     * @throws AuthServiceException
     * @throws InvalidArgumentException
     * @throws ServiceException
     */
    public function createInvoice(User $user, SubscriptionCharge $charge): string;

    /**
     * Returns invoice content.
     *
     * @param string $id Invoice identifier
     *
     * @return string
     *
     * @throws AuthServiceException
     * @throws InvalidArgumentException
     * @throws ServiceException
     */
    public function getInvoice(string $id): string;

    /**
     * Sent user contact in accounting system.
     *
     * @param User $user
     *
     * @return string
     *
     * @throws AuthServiceException
     * @throws InvalidArgumentException
     * @throws ServiceException
     */
    public function createUser(User $user): string;
}
