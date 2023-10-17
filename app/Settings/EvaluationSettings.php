<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class EvaluationSettings extends Settings
{

    public string $grade0;
    public string $grade1;
    public string $grade2;
    public string $grade3;

    public array $grade0Label;
    public array $grade1Label;
    public array $grade2Label;
    public array $grade3Label;

    public array $notation1Title;
    public array $notation2Title;
    public array $notation3Title;

    public array $notation1Description;
    public array $notation2Description;
    public array $notation3Description;

    public static function group(): string
    {
        return 'evaluation';
    }
}
