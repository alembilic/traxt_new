<?php

namespace App\Contracts\Statistics;

use App\Dto\Statistics\StatisticsFilterDto;

/**
 * Contract for services working with statistics.
 */
interface IStatisticsPeriodService
{
    /**
     * Returns statistic data.
     *
     * @param string $type type of statistics
     * @param StatisticsFilterDto $filterDto filter
     *
     * @return IStatisticsPeriod
     */
    public function getPeriodStatistics(string $type, StatisticsFilterDto $filterDto): IStatisticsPeriod;
}
