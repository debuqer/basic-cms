<?php

namespace App\Filament\Resources\Blog\ArticleResource\Pages;

use App\Filament\Resources\Blog\ArticleResource;
use App\Services\Blog\BlogService;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;

class EditArticle extends EditRecord
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
        ];
    }

    public function handleRecordUpdate(Model $record, array $data): Model
    {
        try {
            return App::make(BlogService::class)->updateArticle(id: $record->getKey(), data: $data);
        } catch (ValidationException $exception) {
            Notification::make()->title($exception->getMessage())->danger()->send()->render();

            throw $exception;
        }
    }
}
