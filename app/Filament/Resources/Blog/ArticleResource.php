<?php

namespace App\Filament\Resources\Blog;

use App\Domain\Blog\Constants\ArticleStatus;
use App\Filament\Resources\Blog\ArticleResource\Pages;
use App\Filament\Resources\Blog\Tables\Actions\DraftAction;
use App\Filament\Resources\Blog\Tables\Actions\PublishAction;
use App\Models\Blog\Article;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Let\'s post something')->schema([
                    TextInput::make('title')->label('title'),
                    Textarea::make('content')->label('content'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('content')->words(10),
                Tables\Columns\TextColumn::make('status')->getStateUsing(fn(Model $record) => ArticleStatus::from($record->status)->name),
                Tables\Columns\TextColumn::make('author.name'),
                Tables\Columns\TextColumn::make('published_at')->date('Hd/m/y H:i')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                PublishAction::make(),
                DraftAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('author');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            TextEntry::make('title'),
            TextEntry::make('content'),
            TextEntry::make('status'),
            TextEntry::make('author.name'),
            TextEntry::make('published_at'),
        ]);
    }
}
