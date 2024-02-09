<?php

namespace App\Notifications;

use App\Models\EvaluationOffer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EvaluationOfferNewExpert extends Notification
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
        return (new MailMessage)
            ->subject(__('email.offer_created_invite.title'))
            ->line(__('email.offer_created_invite.intro', [
                'role'        => __('admin.roles.' . $notifiable->extra_attributes->role),
                'projectcall' => $this->evaluationOffer->application->projectCall->toString()
            ]))
            ->action(
                __('email.offer_created_invite.action'),
                route('register') . "?invitation=" . $notifiable->invitation
            )
            ->line(__('email.offer_created_invite.outro'));
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
