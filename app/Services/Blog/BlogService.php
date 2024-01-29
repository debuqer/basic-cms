<?php

namespace App\Services\Blog;

use App\Domain\Blog\BlogRepositoryInterface;
use App\Domain\Blog\Constants\ArticleStatus;
use App\Framework\Database\NonIncrementalKey;
use App\Models\Blog\Article;
use App\Services\Contracts\BlogContract;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Validation\Factory as ValidatorContract;

class BlogService implements BlogContract
{
    public function __construct(
        protected NonIncrementalKey $keyGenerator,
        protected readonly BlogRepositoryInterface $blogRepository,
        protected GateContract $gate,
        protected ValidatorContract $validator,
    ) {

    }

    public function createArticle(array $data): Article
    {
        $this->gate->allows('create', Article::class);
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
        $this->gate->allows('update', Article::find($id));
        $this->validator->make(array_merge($data, ['id' => $id]), [
            'id' => ['required', 'uuid', 'exists:articles,id'],
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
        ])->validate();

        return $this->blogRepository->update(id: $id, data: $data);
    }

    public function publishArticle(string $id,): void
    {
        $this->gate->allows('publish', Article::find($id));
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
        $this->gate->allows('draft', Article::find($id));
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
        $this->gate->allows('softDelete', Article::find($id));
        $this->validator->make(['id' => $id], [
            'id' => ['required', 'uuid', 'exists:articles,id'],
        ])->validate();

        return $this->blogRepository->delete(id: $id);
    }

    public function restoreArticle(string $id): bool
    {
        $this->gate->allows('restore', Article::find($id));
        $this->validator->make(['id' => $id], [
            'id' => ['required', 'uuid', 'exists:articles,id'],
        ])->validate();

        return $this->blogRepository->restore(id: $id);
    }
}
