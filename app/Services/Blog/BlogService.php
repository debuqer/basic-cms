<?php

namespace App\Services\Blog;

use App\Domain\Blog\BlogRepositoryInterface;
use App\Domain\Blog\Constants\ArticleStatus;
use App\Infrastructure\Database\UUID4KeyGenerator;
use App\Models\Blog\Article;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BlogService
{
    public function __construct(
        protected UUID4KeyGenerator $keyGenerator,
        protected readonly BlogRepositoryInterface $blogRepository,
    ) {

    }

    public function createArticle(array $data): Article
    {
        return $this->blogRepository->create([
            'id' => $this->keyGenerator->new(),
            'title' => $data['title'],
            'content' => $data['content'],
            'author_id' => Auth::user()->getAuthIdentifier(),
            'status' => ArticleStatus::Draft->value,
            'created_at' => Carbon::now(),
        ]);
    }

    public function updateArticle(string $id, array $data): Article
    {
        return $this->blogRepository->update(id: $id, data: $data);
    }

    public function publishArticle(string $id,): void
    {
        $this->blogRepository->update(id: $id, data: [
            'status' => ArticleStatus::Published,
            'published_at' => Carbon::now(),
        ]);
    }

    public function draftArticle(string $id,): void
    {
        $this->blogRepository->update(id: $id, data: [
            'status' => ArticleStatus::Draft,
            'published_at' => null,
        ]);
    }

    public function deleteArticle(string $id): bool
    {
        return $this->blogRepository->delete(id: $id);
    }
}
