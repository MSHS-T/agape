<?php

namespace App\Actions\Fortify;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidateCaptcha
{
    public function __invoke(Request $request, $next)
    {
        if (filled(env('HCAPTCHA_SITEKEY', null)) && filled(env('HCAPTCHA_SECRET', null))) {
            Validator::make($request->all(), [
                'h-captcha-response' => ['hcaptcha'],
            ])->validate();
        }

        return $next($request);
    }
}
