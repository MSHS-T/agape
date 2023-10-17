<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public int $defaultNumberOfExperts;
    public int $defaultNumberOfDocuments;
    public int $defaultNumberOfLaboratories;
    public int $defaultNumberOfStudyFields;
    public int $defaultNumberOfKeywords;
    public string $extensionsApplicationForm;
    public string $extensionsFinancialForm;
    public string $extensionsOtherAttachments;


    public static function group(): string
    {
        return 'general';
    }
}
