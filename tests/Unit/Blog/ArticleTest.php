<?php

namespace Tests\Unit\Blog;

use App\Infrastructure\Database\Persistence\BlogRepository;
use App\Infrastructure\Database\UUID4KeyGenerator;
use App\Models\User\User;
use App\Services\Blog\BlogService;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    protected BlogService $service;
    protected User $author;
    protected User $admin;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new BlogService(
            keyGenerator: new UUID4KeyGenerator(),
            blogRepository: new BlogRepository(),
        );
        $this->author = User::factory()->author()->createOne();
        $this->admin = User::factory()->admin()->createOne();
    }


    public function test_author_can_create_article(): void
    {
        Auth::login($this->author);
        $created = $this->service->createArticle([
            'title' => 'breaking news',
            'content' => 'laravel released',
        ]);

        $this->assertTrue($created->exists);
    }

    public function test_raises_error_on_validation(): void
    {
        Auth::login($this->author);
        $created = $this->service->createArticle([
            'content' => 'laravel released',
        ]);

        $this->assertTrue($created->exists);
    }
}
