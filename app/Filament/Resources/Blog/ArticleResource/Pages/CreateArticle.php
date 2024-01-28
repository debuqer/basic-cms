<?php

namespace App\Filament\Resources\Blog\ArticleResource\Pages;

use App\Filament\Resources\Blog\ArticleResource;
use App\Services\Blog\BlogService;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;

    public function handleRecordCreation(array $data): Model
    {
        try {
            return App::make(BlogService::class)->createArticle(data: $data);
        } catch (ValidationException $exception) {
            Notification::make()->title($exception->getMessage())->danger()->send()->render();

            throw $exception;
        }
    }
}
