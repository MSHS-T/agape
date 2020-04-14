<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EvaluationSubmitted extends Notification
{
    use Queueable;

    private $offer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($offer)
    {
        $this->offer = $offer;
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
        $message = (new MailMessage)
            ->subject(__('email.evaluation_submitted.title'))
            ->line(__('email.evaluation_submitted.intro', [
                'expert'   => $this->offer->expert->name,
                'candidat' => $this->offer->application->applicant->name,
                'call'     => $this->offer->application->projectcall->toString()
            ]));

        if ($this->offer->evaluation->devalidation_message !== null) {
            $message->line(__('email.evaluation_submitted.devalidation_line', [
                'justification' => $this->offer->evaluation->devalidation_message
            ]));
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
