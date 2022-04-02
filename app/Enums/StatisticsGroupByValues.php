<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

class StatisticsGroupByValues extends Enum
{
    public const DAYS = 'days';
    public const WEEKS = 'weeks';
    public const MONTHS = 'months';
    public const YEARS = 'years';
    public const STATUS = 'status';
    public const LOST = 'lost';
}
