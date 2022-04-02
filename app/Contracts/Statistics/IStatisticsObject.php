<?php

namespace App\Contracts\Statistics;

/**
 * Contract for services working with statistics object.
 */
interface IStatisticsObject
{
    /**
     * Returns current statistics type.
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Transform data to array.
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Returns total count.
     *
     * @return int
     */
    public function getTotalCount(): int;
}
