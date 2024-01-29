<?php

namespace App\Filament\Resources\Blog;


use App\Filament\Resources\Blog\TrashResource\Pages\ListTrashes;
use App\Models\Blog\Trash;

class TrashResource extends ArticleResource
{
    protected static ?string $model = Trash::class;

    protected static ?string $navigationIcon = 'heroicon-o-trash';


    public static function getPages(): array
    {
        return [
            'index' => ListTrashes::route('/'),
        ];
    }
}
