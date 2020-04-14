<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserInvitationOffer extends Notification
{
    use Queueable;

    private $invitation;
    private $projectcall;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invitation, $projectcall)
    {
        $this->invitation  = $invitation;
        $this->projectcall = $projectcall;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $role = __('vocabulary.role.' . \App\Enums\UserRole::getKey($this->invitation->role));
        return (new MailMessage)
            ->subject(__('email.invitation_offer.title'))
            ->line(__('email.invitation_offer.intro', [
                'role' => $role,
                'projectcall' => $this->projectcall->toString()
            ]))
            ->action(__('email.invitation_offer.action'), url(
                route('register') . "?invitation=" . $this->invitation->invitation
            ))
            ->line(__('email.invitation_offer.outro'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
