<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Override the default email notification
 */
class CustomVerifyEmail extends VerifyEmail
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
            ->subject(__('email.email_verification.title'))
            ->line(__('email.email_verification.intro'))
            ->action(
                __('email.email_verification.action'),
                $this->verificationUrl($notifiable)
            )
            ->line(__('email.email_verification.outro'));
    }
}
