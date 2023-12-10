<?php

namespace App\Rules;

use App\Settings\GeneralSettings;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EmailNotInForbiddenDomains implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $generalSettings = app(GeneralSettings::class);
        if (filled($generalSettings->forbiddenDomains)) {
            $forbiddenDomains = array_map("trim", explode(',', $generalSettings->forbiddenDomains));
            [, $domain] = explode('@', $value);
            if (in_array($domain, $forbiddenDomains)) {
                $fail(__('validation.custom.email.forbidden_domain'));
            }
        }
    }
}
