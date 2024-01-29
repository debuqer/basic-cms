<?php

namespace App\Policies;

use App\Domain\User\Constants\UserRole;
use App\Models\Blog\Article;
use App\Models\User\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Article $article): bool
    {
        return $user->role === UserRole::Admin->value or $article->author_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->role === UserRole::Author->value;
    }

    public function update(User $user, Article $article): bool
    {
        return $user->role === UserRole::Author->value;
    }

    public function delete(User $user, Article $article): bool
    {
        return $user->role === UserRole::Admin->value;
    }

    public function restore(User $user, Article $article): bool
    {
        return $user->role === UserRole::Admin->value;
    }

    public function forceDelete(User $user, Article $article): bool
    {
        return $user->role === UserRole::Admin->value;
    }

    public function publish(User $user, Article $article): bool
    {
        return $user->role === UserRole::Admin->value;
    }

    public function draft(User $user, Article $article): bool
    {
        return $user->role === UserRole::Admin->value;
    }
}
