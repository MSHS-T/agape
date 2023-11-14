<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Concerns\CanBeCollapsed;
use Filament\Forms\Components\Tabs;
use Filament\Support\Concerns\HasDescription;
use Filament\Support\Concerns\HasHeading;
use Filament\Support\Concerns\HasIcon;
use Filament\Support\Concerns\HasIconColor;

class TitledTabs extends Tabs
{
    use CanBeCollapsed;
    use HasDescription;
    use HasHeading;
    use HasIcon;
    use HasIconColor;

    protected string $view = 'forms.components.titled-tabs';
}
