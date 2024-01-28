<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Domain\User\Constants\UserRole;
use App\Models\Blog\Article;
use App\Models\User\User;
use App\Policies\ArticlePolicy;
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
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('publish', [ArticlePolicy::class, 'publish']);
    }
}
