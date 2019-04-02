<?php

namespace App\Http\Controllers;

use App\Invitation;
use App\User;
use App\Enums\UserRole;
use App\Notifications\UserInvitation;

use Illuminate\Http\Request;
use BenSampo\Enum\Rules\EnumValue;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::withTrashed()->orderBy('id', 'desc')->get();
        return view('user.index', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users|unique:invitations',
            'role'  => ['required', 'integer', new EnumValue(UserRole::class, false)]
        ]);

        do {
            $invitationCode = str_random(32);
        } while(Invitation::find($invitationCode) !== null);

        $invitation = new Invitation([
            'invitation' => $invitationCode,
            'email'      => $request->input('email'),
            'role'       => (int) $request->input('role'),
        ]);
        $invitation->save();

        $invitation->notify(new UserInvitation($invitation));

        return redirect()->route('user.index')
                         ->with('success', __('actions.user.invited'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        $user = User::withTrashed()->where('id', $user)->firstOrFail();

        if($user->trashed()){
            $user->restore();
            $message = __('actions.user.unblocked');
        } else {
            $user->delete();
            $message = __('actions.user.blocked');
        }
        return redirect()->route('user.index')
                         ->with('success', $message);
    }
}
