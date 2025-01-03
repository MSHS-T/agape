<?php

namespace App\Notifications;

use App\Models\EvaluationOffer;
use App\Settings\GeneralSettings;
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
        $message = (new MailMessage)
            ->subject(__('email.offer_declined.title'))
            ->line(__('email.offer_declined.intro', [
                'expert'   => $this->evaluationOffer->expert->name,
                'candidat' => $this->evaluationOffer->application->creator->name,
                'call'     => $call->toString()
            ]))
            ->line(__('email.offer_declined.outro', [
                'justification' => $this->evaluationOffer->justification
            ]));

        $generalSettings = app(GeneralSettings::class);
        if ($generalSettings->notificationsCc) {
            $cc = array_map('trim', explode(',', $generalSettings->notificationsCc));
            $message->cc($cc);
        }

        if ($generalSettings->notificationsBcc) {
            $bcc = array_map('trim', explode(',', $generalSettings->notificationsBcc));
            $message->bcc($bcc);
        }

        return $message;
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
