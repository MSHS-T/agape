<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EvaluationUnsubmitted extends Notification
{
    use Queueable;

    private $evaluation;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($evaluation)
    {
        $this->evaluation = $evaluation;
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
        return (new MailMessage)
                    ->subject(__('email.evaluation_unsubmitted.title'))
                    ->line(__('email.evaluation_unsubmitted.intro', [
                        'call'     => $this->evaluation->offer->application->projectcall->toString(),
                        'candidat' => $this->evaluation->offer->application->applicant->name,
                    ]))
                    ->line(__('email.evaluation_unsubmitted.outro', [
                        'justification' => $this->evaluation->devalidation_message
                    ]))
                    ->action(__('email.evaluation_unsubmitted.action'), url(config('app.url').route('evaluation.edit', $this->evaluation->id, false)));
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
