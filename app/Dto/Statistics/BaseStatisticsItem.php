<?php

namespace App\Dto\Statistics;

use App\Contracts\Statistics\IStatisticsItem;
use App\Dto\BaseDtoWrapper;
use DateTimeInterface;

class BaseStatisticsItem  extends BaseDtoWrapper implements IStatisticsItem
{
    public const KEY = 'key';
    public const COUNT = 'count';
    public const TITLE = 'title';
    public const DATE = 'date';

    public string $key = '';
    public string $title = '';
    public ?DateTimeInterface $date = null;
    public int $count = 0;

    public function getKey(): string
    {
        return $this->key;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}
