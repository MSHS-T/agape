<?php

namespace App\Http\Controllers;
use App\ProjectCall;
use App\EvaluationOffer;
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
                $data = compact('projectcalls');
                break;
            case UserRole::Admin:
                $projectcalls = ProjectCall::with('applications')->get();
                $data = compact('projectcalls');
                break;
            case UserRole::Expert:
                $offers = EvaluationOffer::with(['application', 'application.projectcall'])
                    ->where('accepted', null)
                    ->get();
                $accepted = EvaluationOffer::with(['application', 'application.projectcall'])
                    ->where('accepted', true)
                    ->doesntHave('evaluation')
                    ->get();
                $done = EvaluationOffer::with(['application', 'application.projectcall', 'evaluation'])
                    ->where('accepted', true)
                    ->has('evaluation')
                    ->get();
                $data = compact('offers', 'accepted', 'done');
        }
        return view('home', $data);
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
