<?php

namespace App\Notifications;

use App\Models\EvaluationOffer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EvaluationOfferRejected extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected EvaluationOffer $evaluationOffer)
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
        $call = $this->evaluationOffer->application->projectcall;
        return (new MailMessage)
            ->subject(__('email.offer_declined.title'))
            ->line(__('email.offer_declined.intro', [
                'expert'   => $this->evaluationOffer->expert->name,
                'candidat' => $this->evaluationOffer->application->creator->name,
                'call'     => $call->toString()
            ]))
            ->line(__('email.offer_declined.outro', [
                'justification' => $this->evaluationOffer->justification
            ]));
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
