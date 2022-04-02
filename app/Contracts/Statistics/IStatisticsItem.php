<?php

namespace App\Contracts\Statistics;

/**
 * Contract for services working with statistics items.
 */
interface IStatisticsItem
{
    /**
     * Returns item name.
     *
     * @return string
     */
    public function getKey(): string;

    /**
     * Returns item count.
     *
     * @return int
     */
    public function getCount(): int;
}
