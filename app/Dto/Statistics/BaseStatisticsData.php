<?php

namespace App\Dto\Statistics;

use App\Contracts\Statistics\IStatisticsObject;
use App\Dto\BaseDtoWrapper;

abstract class BaseStatisticsData extends BaseDtoWrapper implements IStatisticsObject
{
    public const TYPE = 'type';
    public const TOTAL_COUNT = 'totalCount';
    public const ITEMS = 'items';

    /**
     * Statistics type.
     *
     * @var string
     */
    public string $type;

    /**
     * Total count.
     *
     * @var integer
     */
    public int $totalCount;

    /**
     * Items.
     *
     * @var array
     */
    public array $items;

    /**
     * {@inheritDoc}
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * {@inheritDoc}
     */
    public function getTotalCount(): int
    {
        return $this->totalCount;
    }
}
