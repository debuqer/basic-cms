<?php

namespace App\Filament\Resources\Blog\Tables\Actions;

use App\Services\Blog\BlogService;
use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Support\Facades\FilamentIcon;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;


class DraftAction extends Action
{
    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'draft';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Draft');

        $this->successNotificationTitle(__('filament-actions::edit.single.notifications.saved.title'));

        $this->icon(FilamentIcon::resolve('actions::draft-action') ?? 'heroicon-m-pencil-square');

        $this->action(function (): void {
            $this->process(function (array $data, Model $record, Table $table) {
                App::make(BlogService::class)->draftArticle($record->id);
            });

            $this->success();
        });

        $this->visible(static function (Model $record): bool {
            return ! $record->trashed() and $record->published();
        });

        $this->authorize(static fn (Model $record): bool => (Gate::allows('publish', $record)));
    }
}
