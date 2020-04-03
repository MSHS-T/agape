<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EvaluationForceSubmitted extends Notification
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
        $call = $this->evaluation->offer->application->projectcall;
        return (new MailMessage)
                    ->subject(__('email.evaluation_force_submitted.title'))
                    ->line(__('email.evaluation_force_submitted.intro', [
                        'expert' => $this->evaluation->offer->expert->name,
                        'candidat' => $this->evaluation->offer->application->applicant->name,
                        'call' => $call->toString()
                    ]));
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
