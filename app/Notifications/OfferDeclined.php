<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OfferDeclined extends Notification
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
        $call = $this->offer->application->projectcall;
        return (new MailMessage)
                    ->subject(__('email.offer_declined.title'))
                    ->line(__('email.offer_declined.intro', [
                        'expert' => $this->offer->expert->name,
                        'candidat' => $this->offer->application->applicant->name,
                        'call' => sprintf("%s - %d (%s)", $call->typeLabel, $call->year, $call->title)
                    ]))
                    ->line(__('email.offer_declined.outro', [
                        'justification' => $this->offer->justification
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
