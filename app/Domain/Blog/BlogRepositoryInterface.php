<?php

namespace App\Domain\Blog;


use App\Models\Blog\Article;

interface BlogRepositoryInterface
{
    public function save(Article $article): Article;

    public function delete(string $id);
}
