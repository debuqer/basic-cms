<?php

namespace App\Services\Blog\DTOs;

use App\Framework\Services\DTO\BaseDTO;

readonly class CreateArticleDTO extends BaseDTO
{
    public function __construct(
        public string $title,
        public string $content,
    ) {

    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
