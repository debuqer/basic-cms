<?php

namespace App\Providers\Filament;

class AuthorPanelProvider extends BasePanelProvider
{
    protected function getId(): string
    {
        return 'author';
    }

    protected function getPath(): string
    {
        return 'author';
    }
}
