<?php

namespace App\Infrastructure\Database\Persistence;

use App\Domain\Blog\BlogRepositoryInterface;
use App\Models\Blog\Article;

class BlogRepository implements BlogRepositoryInterface
{

    public function save(Article $article): Article
    {
        return Article::updateOrCreate([
                'id' => $article->id,
            ], [
            'title' => $article->title,
            'content' => $article->content,
            'status' => $article->status,
            'author_id' => $article->author_id,
            'created_at' => $article->created_at,
            'deleted_by' => $article->created_by,
            'deleted_at' => $article->deleted_at,
        ]);
    }

    public function delete(string $id)
    {
        // TODO: Implement delete() method.
    }
}
