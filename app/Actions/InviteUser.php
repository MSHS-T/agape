<?php

namespace App\Actions;

use App\Models\Invitation;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class InviteUser
{
    public static function handle(string $email, string $role, array $projectCallTypes = [], string $lang = null, bool $quietly = false): ?Invitation
    {
        if (Role::where('name', $role)->first() === null) {
            throw new \InvalidArgumentException("Role '$role' does not exist");
        }

        // Generate invitation code
        do {
            $invitationCode = Str::random(32);
        } while (Invitation::whereInvitation($invitationCode)->count() > 0);

        $invitation = new Invitation([
            'invitation' => $invitationCode,
            'email'      => $email
        ]);

        $invitation->extra_attributes['lang'] = $lang;
        $invitation->extra_attributes['role'] = $role;
        $invitation->extra_attributes['project_call_types'] = $role === 'manager' ? $projectCallTypes : [];

        $saveMethod = $quietly ? 'saveQuietly' : 'save';
        $invitation->$saveMethod();

        return $invitation;
    }
}
