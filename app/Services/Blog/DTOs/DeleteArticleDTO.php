<?php

namespace App\Services\Blog\DTOs;

use App\Framework\Services\DTO\BaseDTO;

readonly class DeleteArticleDTO extends BaseDTO
{
    public function __construct(
        public string $id,
    ) {

    }

    public function getId(): string
    {
        return $this->id;
    }
}
