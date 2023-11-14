<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.defaultNumberOfDocuments', 10);
        $this->migrator->add('general.defaultNumberOfLaboratories', 5);
        $this->migrator->add('general.defaultNumberOfStudyFields', 4);
        $this->migrator->add('general.defaultNumberOfKeywords', 5);
        $this->migrator->add('general.enableApplicationForm', true);
        $this->migrator->add('general.enableFinancialForm', true);
        $this->migrator->add('general.enableAdditionalInformation', false);
        $this->migrator->add('general.enableOtherAttachments', true);
        $this->migrator->add('general.extensionsApplicationForm', '.doc,.docx,.odt,.pdf');
        $this->migrator->add('general.extensionsFinancialForm', '.xls,.xlsx,.ods,.doc,.docx,.odt.pdf');
        $this->migrator->add('general.extensionsAdditionalInformation', '.doc,.docx,.odt,.pdf');
        $this->migrator->add('general.extensionsOtherAttachments', '.pdf,.doc,.docx,.odt,.xls,.xlsx,.ods,.jpg,.jpeg,.png,.gif,.zip,.rar,.tar');
    }
};
