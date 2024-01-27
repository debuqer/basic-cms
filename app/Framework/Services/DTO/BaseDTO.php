<?php

namespace App\Framework\Services\DTO;

abstract readonly class BaseDTO
{
    public static function fromArray(array $array): static
    {
        return new static(...$array);
    }
}
