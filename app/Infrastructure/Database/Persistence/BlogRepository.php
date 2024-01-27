<?php

namespace App\Infrastructure\Database\Persistence;

use App\Domain\Blog\BlogRepositoryInterface;
use App\Models\Blog\Article;

class BlogRepository implements BlogRepositoryInterface
{

    public function create(array $data): Article
    {
        return Article::create($data);
    }


    public function update(string $id, array $data): Article
    {
        $article = Article::find($id);
        $article->update($data);

        return $article;
    }

    public function delete(string $id): bool
    {
        return Article::where('id', $id)->delete();
    }

}
