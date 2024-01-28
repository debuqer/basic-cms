<?php

namespace App\Providers;

use App\Domain\Blog\BlogRepositoryInterface;
use App\Framework\Authorization\AuthorizationInterface;
use App\Framework\Database\NonIncrementalKey;
use App\Infrastructure\Authorization\AuthorizationService;
use App\Infrastructure\Database\Persistence\BlogRepository;
use App\Infrastructure\Database\UUID4KeyGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthorizationInterface::class, fn($app) => new AuthorizationService(config('permissions', [])));
        $this->app->bind(NonIncrementalKey::class, UUID4KeyGenerator::class);
        $this->app->bind(BlogRepositoryInterface::class, BlogRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
