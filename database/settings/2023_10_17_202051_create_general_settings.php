<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.defaultNumberOfExperts', 5);
        $this->migrator->add('general.defaultNumberOfDocuments', 10);
        $this->migrator->add('general.defaultNumberOfLaboratories', 5);
        $this->migrator->add('general.defaultNumberOfStudyFields', 4);
        $this->migrator->add('general.defaultNumberOfKeywords', 5);
        $this->migrator->add('general.extensionsApplicationForm', '.doc,.docx,.pdf');
        $this->migrator->add('general.extensionsFinancialForm', '.xls,.xlsx,.doc,.docx,.pdf');
        $this->migrator->add('general.extensionsOtherAttachments', '.pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.zip,.rar,.tar');
    }
};
