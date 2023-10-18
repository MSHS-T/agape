<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // TODO : redirect admins from all front-end pages instead
        if (Auth::user()->hasRole('administrator')) {
            return redirect()->route('filament.admin.pages.dashboard');
        }
        return view('home');
    }
}
