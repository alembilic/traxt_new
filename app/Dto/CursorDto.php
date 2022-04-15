<?php

namespace App\Dto;

/**
 * Data to get cursor.
 */
class CursorDto extends BaseDtoWrapper
{
    public const LIMIT = 'limit';
    public const COUNT = 'count';

    /**
     * Records count.
     *
     * @var integer
     */
    public $limit;

    /**
     * Cursor data.
     *
     * @var integer
     */
    public $count;

    /**
     * Returns limit value.
     *
     * @return integer
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * Returns count value.
     *
     * @return integer
     */
    public function getCursor(): int
    {
        return $this->count;
    }
}
