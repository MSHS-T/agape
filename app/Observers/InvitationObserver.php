<?php

namespace App\Observers;

use App\Models\Invitation;
use App\Notifications\UserInvitation;
use Illuminate\Support\Facades\Auth;

class InvitationObserver
{
    /**
     * Handle the Invitation "created" event.
     */
    public function created(Invitation $invitation): void
    {
        // Send UserInvitation notification
        $invitation->notify((new UserInvitation($invitation))->locale($invitation->extra_attributes->lang));
    }

    /**
     * Handle the Invitation "updated" event.
     */
    public function updated(Invitation $invitation): void
    {
        // Send UserInvitationRetry notification
        $invitation->extra_attributes->retries = array_merge(
            $invitation->extra_attributes->retries ?? [],
            ['at' => now()->toDateTimeString(), 'by' => Auth::id()]
        );
        $invitation->saveQuietly();

        $invitation->notify(new UserInvitation($invitation));
    }
}
