<?php

namespace App\Notifications;

use App\Models\Application;
use App\Settings\GeneralSettings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationSubmittedAdmins extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Application $application)
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
        $call = $this->application->projectCall;
        $message = (new MailMessage)
            ->subject(__('email.new_application_submitted.title'))
            ->line(__('email.new_application_submitted.intro', [
                'name' => $this->application->creator->name,
                'call' => $call->toString()
            ]));
        if ($this->application->devalidation_message !== null) {
            $message->line(__('email.new_application_submitted.devalidation_line', [
                'justification' => $this->application->devalidation_message
            ]));
        }

        $message->action(
            __('email.new_application_submitted.action'),
            route(
                'filament.admin.resources.applications.view',
                ['record' => $this->application->id]
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
