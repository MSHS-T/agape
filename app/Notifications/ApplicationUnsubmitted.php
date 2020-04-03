<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ApplicationUnsubmitted extends Notification
{
    use Queueable;

    private $application;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($application)
    {
        $this->application = $application;
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
        $call = $this->application->projectcall;
        return (new MailMessage)
                    ->subject(__('email.application_unsubmitted.title'))
                    ->line(__('email.application_unsubmitted.intro', [
                        'call'      => $call->toString(),
                        'reference' => $this->application->reference
                    ]))
                    ->line(__('email.application_unsubmitted.outro', [
                        'justification' => $this->application->devalidation_message
                    ]))
                    ->action(__('email.application_unsubmitted.action'), url(config('app.url').route('application.edit', $this->application->id, false)));
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
