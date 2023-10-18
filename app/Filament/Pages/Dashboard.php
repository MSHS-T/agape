<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'fas-home';

    public static function getNavigationLabel(): string
    {
        return __('admin.dashboard.title');
    }

    public function getTitle(): string | Htmlable
    {
        return __('admin.dashboard.title');
    }
}
