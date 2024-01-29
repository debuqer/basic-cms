<?php

namespace App\Services\Blog;

use App\Domain\Blog\BlogRepositoryInterface;
use App\Domain\Blog\Constants\ArticleStatus;
use App\Framework\Database\NonIncrementalKey;
use App\Models\Blog\Article;
use App\Services\Contracts\BlogContract;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Factory as ValidatorContract;
use Illuminate\Validation\UnauthorizedException;

class BlogService implements BlogContract
{
    public function __construct(
        protected NonIncrementalKey $keyGenerator,
        protected readonly BlogRepositoryInterface $blogRepository,
        protected ValidatorContract $validator,
    ) {

    }

    public function createArticle(array $data): Article
    {
        throw_if(Auth::user()->cannot('create', Article::class), UnauthorizedException::class);

        $this->validator->make($data, [
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
        throw_if(Auth::user()->cannot('update', Article::find($id)), UnauthorizedException::class);

        $this->validator->make(array_merge($data, ['id' => $id]), [
            'id' => ['required', 'uuid', 'exists:articles,id'],
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
        ])->validate();

        $data['status'] = ArticleStatus::Draft->value;

        return $this->blogRepository->update(id: $id, data: $data);
    }

    public function publishArticle(string $id,): void
    {
        throw_if(Auth::user()->cannot('publishArticle', Article::find($id)), UnauthorizedException::class);

        $this->validator->make(['id' => $id], [
            'id' => ['required', 'uuid', 'exists:articles,id'],
        ])->validate();

        $this->blogRepository->update(id: $id, data: [
            'status' => ArticleStatus::Published,
            'published_at' => Carbon::now(),
        ]);
    }

    public function draftArticle(string $id,): void
    {
        throw_if(Auth::user()->cannot('draftArticle', Article::find($id)), UnauthorizedException::class);

        $this->validator->make(['id' => $id], [
            'id' => ['required', 'uuid', 'exists:articles,id'],
        ])->validate();

        $this->blogRepository->update(id: $id, data: [
            'status' => ArticleStatus::Draft,
            'published_at' => null,
        ]);
    }

    public function deleteArticle(string $id): bool
    {
        throw_if(Auth::user()->cannot('delete', Article::find($id)), UnauthorizedException::class);

        $this->validator->make(['id' => $id], [
            'id' => ['required', 'uuid', 'exists:articles,id'],
        ])->validate();

        return $this->blogRepository->delete(id: $id);
    }

    public function restoreArticle(string $id): bool
    {
        throw_if(Auth::user()->cannot('restore', Article::find($id)), UnauthorizedException::class);

        $this->validator->make(['id' => $id], [
            'id' => ['required', 'uuid', 'exists:articles,id'],
        ])->validate();

        return $this->blogRepository->restore(id: $id);
    }
}
