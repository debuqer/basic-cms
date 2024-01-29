<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Domain\User\Constants\UserRole;
use App\Models\Blog\Article;
use App\Models\Blog\Trash;
use App\Models\User\User;
use App\Policies\ArticlePolicy;
use App\Policies\TrashPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Article::class => ArticlePolicy::class,
        Trash::class => TrashPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('publishArticle', [ArticlePolicy::class, 'publish']);
        Gate::define('draftArticle', [ArticlePolicy::class, 'draft']);

        Gate::define('publishTrash', [TrashPolicy::class, 'publish']);
        Gate::define('draftTrash', [TrashPolicy::class, 'draft']);
    }
}
