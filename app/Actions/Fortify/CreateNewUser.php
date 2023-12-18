<?php

namespace App\Actions\Fortify;

use App\Models\EvaluationOffer;
use App\Models\Invitation;
use App\Models\User;
use App\Notifications\UserInvitationSignup;
use App\Rules\EmailNotInForbiddenDomains;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:users', new EmailNotInForbiddenDomains],
            'invitation' => ['sometimes', 'string', 'exists:invitations,invitation'],
            'password'   => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'first_name' => $input['first_name'],
            'last_name'  => $input['last_name'],
            'email'      => $input['email'],
            'password'   => Hash::make($input['password']),
        ]);

        /** @var User $user */

        $invitationCode = $input['invitation'] ?? null;
        if (filled($invitationCode)) {
            $invitation = Invitation::where('invitation', $invitationCode)->first();
        } else {
            $invitation = Invitation::where('email', $input['email'])->first();
        }

        if (filled($invitation)) {
            $user->assignRole($invitation->extra_attributes->role);
            $user->projectCallTypes()->sync($invitation->extra_attributes->project_call_types ?? []);

            $creator = User::find($invitation->creator_id ?? null);
            if (filled($creator)) {
                /** @var User $creator */
                $user->extra_attributes->invited_by = [
                    'id'   => $invitation->creator_id,
                    'name' => $invitation->creator->name,
                ];
            }
            $user->save();
            $creator?->notify(new UserInvitationSignup($invitation, $user));

            // Before deleting the invitation, we check if we have evaluationoffers linked to it and transfer the link to the new user instead
            $offers = EvaluationOffer::where('invitation_id', $invitation->id)->get();
            foreach ($offers as $offer) {
                $offer->invitation_id = null;
                $offer->expert_id = $user->id;
                $offer->save();
            }

            $invitation->delete();
        } else {
            $user->assignRole('applicant');
        }

        return $user;
    }
}
