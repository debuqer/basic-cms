<?php

namespace App\Domain\Blog;


use App\Models\Blog\Article;

interface BlogRepositoryInterface
{
    public function create(array $data): Article;

    public function update(string $id, array $data): Article;

    public function delete(string $id): bool;
}
