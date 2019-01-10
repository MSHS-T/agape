<?php

namespace App\Http\Controllers;
use App\ProjectCall;
use App\Enums\UserRole;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        switch(Auth::user()->role){
            case UserRole::Candidate:
                $projectcalls = ProjectCall::with(['applications' => function($query){
                    $query->where('applicant_id', Auth::id());
                }])->get();
                break;
            case UserRole::Admin:
                $projectcalls = ProjectCall::with('applications')->get();
                break;
            default:
                $projectcalls = [];
        }
        return view('home', compact('projectcalls'));
    }

    /**
     * Show the user's profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('profile', [
            "user" => Auth::user()
        ]);
    }
}
