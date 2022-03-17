<?php

namespace App\Contracts;

use App\Entities\SubscriptionCharge;

/**
 * Contract for Accounting System Handler.
 */
interface IAccountingSystem
{
    public function createInvoice(SubscriptionCharge $charge): string;
    public function getInvoice(string $id): string;
}
