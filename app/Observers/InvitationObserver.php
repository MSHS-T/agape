<?php

namespace App\Observers;

use App\Models\Invitation;
use App\Notifications\UserInvitation;
use App\Notifications\UserInvitationRetry;
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
        $invitation->notify((new UserInvitationRetry($invitation))->locale($invitation->extra_attributes->lang));
    }
}
