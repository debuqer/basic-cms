<?php

namespace App\Filament\Resources\Blog\TrashResource\Pages;

use App\Filament\Resources\Blog\TrashResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrashes extends ListRecords
{
    protected static string $resource = TrashResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
