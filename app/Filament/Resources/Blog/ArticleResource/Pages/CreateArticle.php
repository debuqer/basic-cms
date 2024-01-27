<?php

namespace App\Filament\Resources\Blog\ArticleResource\Pages;

use App\Filament\Resources\Blog\ArticleResource;
use App\Services\Blog\BlogService;
use App\Services\Blog\DTOs\CreateArticleDTO;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;


    public function handleRecordCreation(array $data): Model
    {
        return App::make(BlogService::class)->createPost(CreateArticleDTO::fromArray($data));
    }
}
