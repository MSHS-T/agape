<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ContactRequest extends FormRequest
{
    /**
     * Indicates whether validation should stop after the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [];
        if (!Auth::check() && filled(env('HCAPTCHA_SITEKEY', null)) && filled(env('HCAPTCHA_SECRET', null))) {
            $rules = array_merge(
                $rules,
                [
                    'h-captcha-response' => ['hcaptcha'],
                ]
            );
        }

        $rules = array_merge(
            $rules,
            [
                'name'                  => ['required', 'string', 'max:255'],
                'email'                 => ['required', 'string', 'email', 'max:255'],
                'oversight_affiliation' => ['sometimes', 'string', 'max:255'],
                'message'               => ['required', 'string', 'min:10'],
            ]
        );
        return $rules;
    }
}
