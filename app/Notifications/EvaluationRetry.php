<?php

namespace App\Notifications;

use App\Models\Evaluation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EvaluationRetry extends Notification
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
        $call = $this->evaluation->evaluationOffer->application->projectcall;
        return (new MailMessage)
            ->subject(__('email.evaluation_retry.title'))
            ->line(__('email.evaluation_retry.intro', [
                'candidat' => $this->evaluation->evaluationOffer->application->creator->name,
                'deadline' => $this->evaluation->evaluationOffer->application->projectCall->evaluation_end_date->format('d/m/Y'),
                'call'     => $call->toString()
            ]))
            ->action(__('email.evaluation_retry.action'), route('filament.expert.pages.evaluate', ['offer' => $this->evaluation->evaluationOffer->id], true));
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
