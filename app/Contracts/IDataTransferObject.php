<?php

namespace App\Contracts;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Contract for all Data Transfer Objects.
 */
interface IDataTransferObject extends Arrayable
{
    /**
     * Returns fields which was initialized in this dto.
     *
     * @return array
     */
    public function getInitializedFields(): array;
}
