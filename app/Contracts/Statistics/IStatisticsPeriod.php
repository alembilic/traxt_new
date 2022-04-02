<?php

namespace App\Contracts\Statistics;

interface IStatisticsPeriod
{
    /**
     * Returns current statistics type.
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Current Period.
     *
     * @return IStatisticsObject
     */
    public function getCurrentPeriod(): IStatisticsObject;

    /**
     * Previous Period.
     *
     * @return IStatisticsObject
     */
    public function getPreviousPeriod(): IStatisticsObject;
}
