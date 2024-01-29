<?php

namespace App\Filament\Resources\Blog\ArticleResource\Pages;

use App\Services\Contracts\BlogContract;
use Filament\Actions\DeleteAction as BaseDeleteAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class DeleteAction extends BaseDeleteAction
{
    public function setUp(): void
    {
        parent::setUp();

        $this->action(function (): void {
            $result = $this->process(static fn (Model $record) => App::make(BlogContract::class)->deleteArticle($record->getKey()));

            if (! $result) {
                $this->failure();

                return;
            }

            $this->success();
        });
    }
}
