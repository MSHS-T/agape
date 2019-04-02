<?php

namespace App\Http\Controllers\Auth;

use App\Invitation;
use App\User;
use App\Enums\UserRole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Request $request)
    {
        return view('auth.register', [
            'invitation' => ($request->has('invitation') ? $request->get('invitation') : false)
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name'           => ['required', 'string', 'max:255'],
            'last_name'            => ['required', 'string', 'max:255'],
            'email'                => ['required', 'string', 'email', 'max:255', 'exists:invitations'],
            'password'             => ['required', 'string', 'min:6', 'confirmed'],
            'invitation'           => ['nullable', 'string', 'exists:invitations'],
            'g-recaptcha-response' => 'recaptcha',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if(array_key_exists('invitation', $data)) {
            $invitation = Invitation::findOrFail($data['invitation']);
        }
        else {
            $invitation = Invitation::where('email', $data['email'])->first();
        }
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'invited' => ($invitation !== null),
            'role' => ($invitation ? $invitation->role : UserRole::Candidate)
        ]);
        if($invitation !== null){
            $invitation->delete();
        }
        return $user;
    }
}
