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
        if (Auth::user()->hasAnyRole(['administrator', 'manager'])) {
            return redirect()->route('filament.admin.pages.dashboard');
        }
        if (Auth::user()->hasRole('expert')) {
            return redirect()->route('filament.expert.pages.dashboard');
        } else {
            return redirect()->route('filament.applicant.pages.dashboard');
        }
    }
}
