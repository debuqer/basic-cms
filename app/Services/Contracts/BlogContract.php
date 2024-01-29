<?php

namespace App\Services\Contracts;

use App\Models\Blog\Article;

interface BlogContract
{
    public function createArticle(array $data): Article;

    public function updateArticle(string $id, array $data): Article;

    public function publishArticle(string $id,): void;

    public function draftArticle(string $id,): void;

    public function deleteArticle(string $id): bool;

    public function restoreArticle(string $id): bool;
}
