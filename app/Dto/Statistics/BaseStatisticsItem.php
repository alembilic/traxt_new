<?php

namespace App\Dto\Statistics;

use App\Contracts\Statistics\IStatisticsItem;
use App\Dto\BaseDtoWrapper;

class BaseStatisticsItem  extends BaseDtoWrapper implements IStatisticsItem
{
    public const KEY = 'key';
    public const COUNT = 'count';

    public string $key = '';
    public int $count = 0;

    public function getKey(): string
    {
        return $this->key;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}
