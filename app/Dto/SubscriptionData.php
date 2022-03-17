<?php

namespace App\Dto;

use DateTime;

class SubscriptionData extends BaseDtoWrapper
{
    public const EXTERNAL_ID = 'externalId';
    public const PAYMENT_URL = 'paymentUrl';
    public const ACCOUNTING_SYSTEM_ID = 'accountingSystemId';
    public const STATUS = 'status';
    public const PAYMENT_PERIOD = 'paymentPeriod';
    public const NEXT_DUE_DATE = 'nextDueDate';
    public const CANCEL_DATE = 'cancelDate';
    public const ACTIVE = 'active';

    public $externalId = null;
    public ?string $paymentUrl = null;
    public ?string $accountingSystemId = null;
    public ?string $status = null;
    public ?int $paymentPeriod = null;
    public ?DateTime $nextDueDate = null;
    public ?DateTime $cancelDate = null;
    public ?bool $active;
}
