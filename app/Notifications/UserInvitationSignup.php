<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserInvitationSignup extends Notification
{
    use Queueable;

    private $invitation;
    private $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invitation, $user)
    {
        $this->invitation = $invitation;
        $this->user       = $user;
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
        $user = sprintf("%s (%s)", $this->user->name, $this->user->email);

        $message = (new MailMessage)
            ->subject(__('email.invitation_signup.title'))
            ->line(__('email.invitation_signup.intro', [
                'user' => $user,
                'role' => $role
            ]));
        if ($this->user->email !== $this->invitation->email) {
            $message->line(__('email.invitation_signup.outro', ['email' => $this->invitation->email]));
        }
        return $message;
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
