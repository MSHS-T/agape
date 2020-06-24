<?php

namespace App\Http\Controllers;

use App\Invitation;
use App\User;
use App\Enums\UserRole;
use App\Notifications\UserInvitation;
use App\Notifications\UserInvitationRetry;
use App\Notifications\UserRoleChange;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
            $invitationCode = Str::random(32);
        } while (Invitation::find($invitationCode) !== null);

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
     * Changes user role.
     *
     * @param  string  $user
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeRole($user, Request $request)
    {
        if (intval($user) === 1) {
            throw new \Illuminate\Validation\UnauthorizedException("Le compte administrateur ne peut pas être changé de rôle");
        }
        $newRole = $request->input('role');
        $user = User::where('id', $user)->firstOrFail();
        $user->role = intval($newRole);
        $user->save();

        $newRoleLabel = __('vocabulary.role.' . \App\Enums\UserRole::getKey($user->role));

        $user->notify(new UserRoleChange($user));

        return redirect()->route('user.index')
            ->with('success', __('actions.user.role_changed', ['name' => $user->name, 'role' => $newRoleLabel]));
    }

    /**
     * Soft-deletes (or restores) the given user.
     *
     * @param  string  $user
     * @return \Illuminate\Http\Response
     */
    public function block($user)
    {
        if (intval($user) === 1) {
            throw new \Illuminate\Validation\UnauthorizedException("Le compte administrateur ne peut pas être bloqué");
        }
        $user = User::withTrashed()->where('id', $user)->firstOrFail();

        if ($user->trashed()) {
            $user->restore();
            $message = __('actions.user.unblocked');
        } else {
            $user->delete();
            $message = __('actions.user.blocked');
        }
        return redirect()->route('user.index')
            ->with('success', $message);
    }

    /**
     * Permanently deletes a user
     *
     * @param  string  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        if (intval($user) === 1) {
            throw new \Illuminate\Validation\UnauthorizedException("Le compte administrateur ne peut pas être supprimé");
        }
        $user = User::withTrashed()->where('id', $user)->firstOrFail();
        try {
            $user->forceDelete();
            $message = __('actions.user.deleted');
            $messageType = "success";
        } catch (\Illuminate\Database\QueryException $e) {
            $message = __('actions.user.cannot_be_deleted', ['name' => $user->name]);
            $messageType = "error";
        }

        return redirect()->route('user.index')
            ->with($messageType, $message);
    }

    /**
     * Display a listing of the invited users.
     *
     * @return \Illuminate\Http\Response
     */
    public function invites()
    {
        $invitations = Invitation::orderBy('updated_at', 'desc')->get();
        return view('user.invites', ['invitations' => $invitations]);
    }

    /**
     * Send another invite
     *
     * @param  string $invitationCode
     * @return \Illuminate\Http\Response
     */
    public function inviteRetry($invitationCode)
    {
        $invitation = Invitation::findOrFail($invitationCode);

        $invitation->touch();

        $invitation->notify(new UserInvitationRetry($invitation));

        return redirect()->route('user.invites')
            ->with('success', __('actions.user.invite_sent_again'));
    }
}
