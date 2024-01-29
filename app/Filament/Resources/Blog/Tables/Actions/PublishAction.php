<?php

namespace App\Filament\Resources\Blog\Tables\Actions;

use App\Services\Contracts\BlogContract;
use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Support\Facades\FilamentIcon;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class PublishAction extends Action
{
    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'publish';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('article.actions.publish'));

        $this->successNotificationTitle(__('article.messages.published'));

        $this->icon(FilamentIcon::resolve('actions::publish-action') ?? 'heroicon-m-pencil-square');

        $this->action(function (): void {
            $this->process(function (array $data, Model $record, Table $table) {
                App::make(BlogContract::class)->publishArticle($record->id);
            });

            $this->success();
        });

        $this->requiresConfirmation();

        $this->visible(static function (Model $record): bool {
            return ! $record->trashed() and $record->drafted();
        });

        $this->authorize(static fn (Model $record): bool => (Auth::user()->can('publishArticle', $record)));
    }
}
