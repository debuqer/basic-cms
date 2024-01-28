<?php

namespace App\Services\Blog;

use App\Domain\Blog\BlogRepositoryInterface;
use App\Domain\Blog\Constants\ArticleStatus;
use App\Framework\Database\NonIncrementalKey;
use App\Models\Blog\Article;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BlogService
{
    public function __construct(
        protected NonIncrementalKey $keyGenerator,
        protected readonly BlogRepositoryInterface $blogRepository,
    ) {

    }

    public function createArticle(array $data): Article
    {
        Validator::make($data, [
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
        ])->validate();

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
        Validator::make(array_merge($data, ['id' => $id]), [
            'id' => ['required', 'uuid', 'exists:articles,id'],
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
        ])->validate();

        return $this->blogRepository->update(id: $id, data: $data);
    }

    public function publishArticle(string $id,): void
    {
        Validator::make(['id' => $id], [
            'id' => ['required', 'uuid', 'exists:articles,id'],
        ])->validate();

        $this->blogRepository->update(id: $id, data: [
            'status' => ArticleStatus::Published,
            'published_at' => Carbon::now(),
        ]);
    }

    public function draftArticle(string $id,): void
    {
        Validator::make(['id' => $id], [
            'id' => ['required', 'uuid', 'exists:articles,id'],
        ])->validate();

        $this->blogRepository->update(id: $id, data: [
            'status' => ArticleStatus::Draft,
            'published_at' => null,
        ]);
    }

    public function deleteArticle(string $id): bool
    {
        Validator::make(['id' => $id], [
            'id' => ['required', 'uuid', 'exists:articles,id'],
        ])->validate();

        return $this->blogRepository->delete(id: $id);
    }

    public function restoreArticle(string $id): bool
    {
        Validator::make(['id' => $id], [
            'id' => ['required', 'uuid', 'exists:articles,id'],
        ])->validate();

        return $this->blogRepository->restore(id: $id);
    }
}
