<?php

namespace App\Contracts\Statistics;

use App\Dto\Statistics\StatisticsFilterDto;
use App\Exceptions\DtoException;
use Exception;

/**
 * Contract for services working with statistics.
 */
interface IStatisticsService
{
    /**
     * Returns statistic data.
     *
     * @param StatisticsFilterDto $filterDto filter
     *
     * @return IStatisticsObject
     *
     * @throws DtoException
     * @throws Exception
     */
    public function getStatistics(StatisticsFilterDto $filterDto): IStatisticsObject;

}
