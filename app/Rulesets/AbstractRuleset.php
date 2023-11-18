<?php

namespace App\Rulesets;

abstract class AbstractRuleset
{
    public static function rules(): array
    {
        return [];
    }
    public static function messages(): array
    {
        return [];
    }
    public static function attributes(): array
    {
        return [];
    }
}
