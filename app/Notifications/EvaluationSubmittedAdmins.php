<?php

namespace App\Notifications;

use App\Models\Evaluation;
use App\Settings\GeneralSettings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EvaluationSubmittedAdmins extends Notification
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
        $message = (new MailMessage)
            ->subject(__('email.new_evaluation_submitted.title'))
            ->line(__('email.new_evaluation_submitted.intro', [
                'name' => $this->evaluation->evaluationOffer->expert->name,
                'call' => $this->evaluation->evaluationOffer->application->projectCall->toString()
            ]));
        if ($this->evaluation->devalidation_message !== null) {
            $message->line(__('email.new_evaluation_submitted.devalidation_line', [
                'justification' => $this->evaluation->devalidation_message
            ]));
        }

        $message->action(
            __('email.new_evaluation_submitted.action'),
            route(
                'filament.admin.resources.applications.evaluations',
                ['record' => $this->evaluation->evaluationOffer->application->id],
            )
        );

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
