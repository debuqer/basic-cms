<?php

namespace App\Providers;

use App\Domain\Blog\BlogRepositoryInterface;
use App\Framework\Database\NonIncrementalKey;
use App\Infrastructure\Database\Persistence\BlogRepository;
use App\Infrastructure\Database\UUID4KeyGenerator;
use App\Services\Blog\BlogService;
use App\Services\Contracts\BlogContract;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Validation\Factory as ValidatorContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BlogRepositoryInterface::class, BlogRepository::class);
        $this->app->bind(NonIncrementalKey::class, UUID4KeyGenerator::class);
        $this->app->bind(BlogContract::class, function ($app) {
            return new BlogService(
                keyGenerator: $app->make(NonIncrementalKey::class),
                blogRepository: $app->make(BlogRepositoryInterface::class),
                gate: $app->make(GateContract::class),
                validator: $app->make(ValidatorContract::class),
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
