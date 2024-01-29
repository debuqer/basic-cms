<?php

namespace Tests\Unit\Blog;

use App\Domain\Blog\Constants\ArticleStatus;
use App\Models\Blog\Article;
use App\Models\User\User;
use App\Services\Blog\BlogService;
use App\Services\Contracts\BlogContract;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    protected BlogService $service;
    protected User $nonPrivilegedUser;
    protected User $author;
    protected User $admin;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = App::make(BlogContract::class);
        $this->nonPrivilegedUser = User::factory()->nonPrivilegedUser()->createOne();
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
        $this->assertEquals(ArticleStatus::Draft->value, $created->status);
        $this->assertNull($created->published_at);
    }

    public function test_non_privileged_user_cant_create_article(): void
    {
        $this->expectException(UnauthorizedException::class);
        Auth::login($this->nonPrivilegedUser);
        $this->service->createArticle([
            'title' => 'breaking news',
            'content' => 'laravel released',
        ]);
    }

    public function test_throws_exception_on_create_input_validation(): void
    {
        $this->expectException(ValidationException::class);
        Auth::login($this->author);

        $created = $this->service->createArticle([
            'content' => 'laravel released',
        ]);

        $this->assertTrue($created->exists);
    }

    public function test_author_can_update_article(): void
    {
        $article = Article::factory()->createOne();
        Auth::login($this->author);

        $updated = $this->service->updateArticle($article->id, [
            'title' => 'foo',
            'content' => $article->content,
        ]);

        $this->assertEquals('foo', $updated->title);
    }

    public function test_non_privileged_user_cant_update_article(): void
    {
        $this->expectException(UnauthorizedException::class);
        $article = Article::factory()->createOne();
        Auth::login($this->nonPrivilegedUser);

        $this->service->updateArticle($article->id, [
            'title' => 'foo',
            'content' => $article->content,
        ]);
    }

    public function test_throws_exception_on_update_input_validation(): void
    {
        $this->expectException(ValidationException::class);
        $article = Article::factory()->createOne();
        Auth::login($this->author);

        $this->service->updateArticle($article->id, [
            'title' => 'foo',
        ]);
    }

    public function test_update_published_article_makes_it_draft(): void
    {
        $article = Article::factory()->published()->createOne();
        Auth::login($this->author);

        $updated = $this->service->updateArticle($article->id, [
            'title' => 'foo',
            'content' => $article->content,
        ]);

        $this->assertEquals(ArticleStatus::Draft->value, $updated->status);
    }

    public function test_admin_can_delete_article(): void
    {
        $article = Article::factory()->createOne();
        Auth::login($this->admin);

        $deleted = $this->service->deleteArticle($article->id);

        $this->assertTrue($deleted);
        $this->assertTrue($article->refresh()->trashed());
    }

    public function test_non_privileged_user_cant_delete_article(): void
    {
        $this->expectException(UnauthorizedException::class);
        $article = Article::factory()->createOne();
        Auth::login($this->author);

        $this->service->deleteArticle($article->id);
    }

    public function test_deleted_article_cant_be_deleted_again(): void
    {
        $this->expectException(UnauthorizedException::class);
        $article = Article::factory()->deleted()->createOne();
        Auth::login($this->admin);

        $this->service->deleteArticle($article->id);
    }

    public function test_deleted_article_can_be_restored(): void
    {
        $this->expectException(UnauthorizedException::class);
        $article = Article::factory()->deleted()->createOne();
        Auth::login($this->admin);

        $restored = $this->service->restoreArticle($article->id);

        $this->assertTrue($restored);
        $this->assertTrue($article->refresh()->exists);
    }

    public function test_non_privileged_user_cant_restore_article(): void
    {
        $this->expectException(UnauthorizedException::class);
        $article = Article::factory()->deleted()->createOne();
        Auth::login($this->author);

        $this->service->restoreArticle($article->id);
    }

    public function test_admin_can_publish_article(): void
    {
        $article = Article::factory()->drafted()->createOne();
        Auth::login($this->admin);

        $this->service->publishArticle($article->id);

        $this->assertEquals(ArticleStatus::Published->value, $article->refresh()->status);
    }

    public function test_non_privileged_user_cant_publish_article(): void
    {
        $this->expectException(UnauthorizedException::class);
        $article = Article::factory()->drafted()->createOne();
        Auth::login($this->author);

        $this->service->publishArticle($article->id);
    }


    public function test_admin_can_draft_article(): void
    {
        $article = Article::factory()->published()->createOne();
        Auth::login($this->admin);

        $this->service->draftArticle($article->id);

        $this->assertEquals(ArticleStatus::Draft->value, $article->refresh()->status);
    }

    public function test_non_privileged_user_cant_draft_article(): void
    {
        $this->expectException(UnauthorizedException::class);
        $article = Article::factory()->published()->createOne();
        Auth::login($this->author);

        $this->service->draftArticle($article->id);
    }

}
