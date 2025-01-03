<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.notificationsToAdmins', true);
        $this->migrator->add('general.notificationsToManagers', true);
        $this->migrator->add('general.notificationsToProjectCallCreator', true);
        $this->migrator->add('general.notificationsCc', '');
        $this->migrator->add('general.notificationsBcc', '');
    }
};
