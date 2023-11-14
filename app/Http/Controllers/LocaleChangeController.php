<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocaleChangeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $locale)
    {
        Session::put('locale', $locale);
        return redirect()->back();
    }
}
