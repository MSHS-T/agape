<?php

namespace App\Filament\Widgets;

use App\Utils\Version;
use Filament\Widgets\Widget;

class VersionInfo extends Widget
{
    protected static string $view = 'filament.widgets.version-info';

    public string $version;

    public function mount()
    {
        $this->version = Version::get()['string'];
    }
}
