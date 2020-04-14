<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Override the default reset password email
 */
class CustomResetPassword extends ResetPassword
{
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('email.reset_password.title'))
            ->line(__('email.reset_password.intro'))
            ->action(__('email.reset_password.action'), url(config('app.url') . route('password.reset', $this->token, false)))
            ->line(__('email.reset_password.outro'));
    }
}
