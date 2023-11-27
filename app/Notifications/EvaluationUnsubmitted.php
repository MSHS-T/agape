<?php

namespace App\Notifications;

use App\Models\Evaluation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EvaluationUnsubmitted extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Evaluation $evaluation)
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
            ->subject(__('email.evaluation_unsubmitted.title'))
            ->line(__('email.evaluation_unsubmitted.intro', [
                'call'     => $this->evaluation->evaluationOffer->application->projectCall->toString(),
                'candidat' => $this->evaluation->evaluationOffer->application->creator->name,
            ]))
            ->line(__('email.evaluation_unsubmitted.outro', [
                'justification' => $this->evaluation->devalidation_message
            ]))
            ->action(
                __('email.evaluation_unsubmitted.action'),
                route('filament.expert.pages.evaluate', ['offer' => $this->evaluation->evaluationOffer->id], true)
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
