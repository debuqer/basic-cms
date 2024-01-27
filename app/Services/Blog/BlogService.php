<?php

namespace App\Services\Blog;

use App\Domain\Blog\BlogRepositoryInterface;
use App\Domain\Blog\Constants\ArticleStatus;
use App\Infrastructure\Database\UUID4KeyGenerator;
use App\Models\Blog\Article;
use App\Services\Blog\DTOs\ApproveArticleDTO;
use App\Services\Blog\DTOs\CreateArticleDTO;
use App\Services\Blog\DTOs\DeleteArticleDTO;
use App\Services\Blog\DTOs\UpdateArticleDTO;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BlogService
{
    public function __construct(
        protected UUID4KeyGenerator $keyGenerator,
        protected readonly BlogRepositoryInterface $blogRepository,
    ) {

    }

    public function createPost(CreateArticleDTO $dto): Article
    {
        $article = new Article();
        $article->setRawAttributes([
            'id' => $this->keyGenerator->new(),
            'title' => $dto->getTitle(),
            'content' => $dto->getContent(),
            'author_id' => Auth::user()->getAuthIdentifier(),
            'status' => ArticleStatus::Draft->value,
            'created_at' => Carbon::now(),
        ]);

        return $this->blogRepository->save($article);
    }

    public function updatePost(UpdateArticleDTO $dto)
    {

    }

    public function approveDraft(ApproveArticleDTO $dto)
    {

    }

    public function deleteArticle(DeleteArticleDTO $dto)
    {

    }
}
