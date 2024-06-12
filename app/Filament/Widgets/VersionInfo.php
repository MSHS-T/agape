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
        $versionArray = Version::get();
        if (is_null($versionArray)) {
            return null;
        } else {
            $this->version = $versionArray['string'];
        }
    }
}
