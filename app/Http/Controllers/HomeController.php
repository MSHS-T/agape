<?php

namespace App\Http\Controllers;
use App\ProjectCall;
use App\EvaluationOffer;
use App\Enums\UserRole;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
                $open_calls = ProjectCall::with(['applications' => function($query){
                    $query->where('applicant_id', Auth::id());
                }])->open()->get();
                $old_calls = ProjectCall::with(['applications' => function($query){
                    $query->where('applicant_id', Auth::id());
                }])->old()->get();
                $data = compact('open_calls', 'old_calls');
                break;
            case UserRole::Admin:
                $projectcalls = ProjectCall::with('applications')->open()->get();
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
        return view('user.edit', [
            "user"        => Auth::user(),
            "mode"        => "edit",
            "form_action" => route('profile.save')
        ]);
    }

    /**
     * Updates the contents of a user's profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveProfile(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();
        $validator = Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);
        if ($validator->fails()) {
            return redirect()
                        ->route('profile')
                        ->withErrors($validator)
                        ->withInput();
        }
        $data = $request->only(['first_name', 'last_name', 'email', 'phone']);
        $user->fill($data);

        if($request->filled(['password', 'password_confirmation'])) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();

        return redirect()->route('home')
                         ->with('success', __('actions.profile_edited'));
    }
}
