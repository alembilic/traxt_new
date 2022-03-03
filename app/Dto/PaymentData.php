<?php

namespace App\Dto;

class PaymentData extends BaseDtoWrapper
{
    public const ID = 'id';
    public const STATUS = 'status';
    public const TOKEN = 'token';

    public string $id;
    public int $status;

    public function getId(): string
    {
        return $this->id;
    }

    public function getStatus(): int
    {
        return $this->status;
    }
}
