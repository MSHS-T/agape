<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationUnsubmitted extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Application $application)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $call = $this->application->projectCall;
        return (new MailMessage)
            ->subject(__('email.application_unsubmitted.title'))
            ->line(__('email.application_unsubmitted.intro', [
                'call'      => $call->toString(),
                'reference' => $this->application->reference
            ]))
            ->line(__('email.application_unsubmitted.outro', [
                'justification' => $this->application->devalidation_message
            ]))
            ->action(
                __('email.application_unsubmitted.action'),
                url(config('app.url') . route('filament.applicant.pages.apply', $call->id, true))
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
