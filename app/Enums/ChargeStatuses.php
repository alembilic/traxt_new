<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

class ChargeStatuses extends Enum
{
    public const PENDING = 'pending';
    public const FAIL = 'fail';
    public const COMPLETE = 'complete';
}
