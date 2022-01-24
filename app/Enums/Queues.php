<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

class Queues extends Enum
{
    public const ORDERS = 'orders-queue';
    public const IMPORT = 'import-queue';
    public const NOTIFICATIONS = 'notifications-queue';
}
