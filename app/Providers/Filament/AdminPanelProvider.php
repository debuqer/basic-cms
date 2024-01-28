<?php

namespace App\Providers\Filament;

class AdminPanelProvider extends BasePanelProvider
{
    protected function getId(): string
    {
        return 'admin';
    }

    protected function getPath(): string
    {
        return 'admin';
    }
}
