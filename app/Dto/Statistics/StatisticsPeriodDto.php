<?php

namespace App\Dto\Statistics;

use App\Contracts\Statistics\IStatisticsObject;
use App\Contracts\Statistics\IStatisticsPeriod;
use App\Contracts\Statistics\IStatisticsService;
use App\Enums\StatisticsTypes;
use App\Exceptions\DtoException;

class StatisticsPeriodDto implements IStatisticsPeriod
{
    private ?IStatisticsObject $currentPeriod = null;
    private ?IStatisticsObject $previousPeriod = null;
    private StatisticsFilterDto $filter;
    private StatisticsFilterDto $previousPeriodFilter;
    private IStatisticsService $service;
    private StatisticsTypes $type;

    public function __construct(
        StatisticsTypes $type,
        IStatisticsService $service,
        StatisticsFilterDto $filter,
        StatisticsFilterDto $previousPeriodFilter,
    ) {
        $this->type = $type;
        $this->service = $service;
        $this->previousPeriodFilter = $previousPeriodFilter;
        $this->filter = $filter;
    }

    /**
     * Returns current statistics type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Returns statistics current period.
     *
     * @return IStatisticsObject
     *
     * @throws DtoException
     */
    public function getCurrentPeriod(): IStatisticsObject
    {
        if (!$this->currentPeriod) {
            $this->currentPeriod = $this->service->getStatistics($this->filter);
        }

        return $this->currentPeriod;
    }

    /**
     * Returns statistics previous period.
     *
     * @return IStatisticsObject
     *
     * @throws DtoException
     */
    public function getPreviousPeriod(): IStatisticsObject
    {
        if (!$this->previousPeriod) {
            $this->previousPeriod = $this->service->getStatistics($this->previousPeriodFilter);
        }

        return $this->previousPeriod;
    }
}
