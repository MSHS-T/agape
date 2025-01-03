<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EmailList implements ValidationRule
{
    public function __construct(protected string $separator = ',') {}

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)) {
            $fail(__('validation.string', ['attribute' => $attribute]));
        }

        $emails = explode($this->separator, $value);
        foreach ($emails as $email) {
            $email = trim($email);
            if (filled($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $fail(__('validation.email', ['attribute' => $attribute]));
            }
        }
    }
}
