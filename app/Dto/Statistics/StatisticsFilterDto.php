<?php

namespace App\Dto\Statistics;

use App\Dto\BaseDtoWrapper;
use App\Entities\User;
use Carbon\Carbon;

/**
 * Dto to filter statistic data.
 */
class StatisticsFilterDto extends BaseDtoWrapper
{
    public const USER = 'user';
    public const START = 'periodStart';
    public const END = 'periodEnd';
    public const GROUP_BY = 'groupBy';

    /**
     * Statistic organisation.
     *
     * @var object|User|null
     */
    public $user;

    /**
     * Statistic start period.
     *
     * @var Carbon|object|null
     */
    public $periodStart;

    /**
     * Statistic start period.
     *
     * @var Carbon|object|null
     */
    public $periodEnd;

    /**
     * Statistic start period.
     *
     * @var string|null
     */
    public ?string $groupBy = null;
}
