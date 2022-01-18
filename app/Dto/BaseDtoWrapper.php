<?php

namespace App\Dto;

use App\Contracts\IDataTransferObject;
use App\Exceptions\DtoException;
use ReflectionClass;
use Spatie\DataTransferObject\DataTransferObject;
use Throwable;

/**
 * Wraps `spatie/data-transfer-object` library to application appropriate class.
 */
abstract class BaseDtoWrapper extends DataTransferObject implements IDataTransferObject
{
    /**
     * Fields initialized only in this data.
     *
     * @var array
     */
    protected $initializedFields = [];

    /**
     * BaseDtoWrapper constructor.
     *
     * @param array $parameters Data transfer object parameters
     *
     * @throws DtoException
     */
    public function __construct(array $parameters)
    {
        try {
            $this->initializedFields = array_intersect(array_keys($parameters), static::getFields());
            parent::__construct($parameters);
        } catch (Throwable $exception) {
            throw new DtoException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getInitializedFields(): array
    {
        return $this->initializedFields;
    }

    /**
     * Returns all fields available in this dto.
     *
     * @return array
     */
    public static function getFields(): array
    {
        $class = new ReflectionClass(static::class);

        return array_values($class->getConstants());
    }
}
