<?php

namespace App\Notifications;

use App\Models\EvaluationOffer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EvaluationOfferExistingExpert extends Notification
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
        $projectCall = $this->evaluationOffer->application->projectCall;
        $message = (new MailMessage)->subject(__('email.offer_created.title'));

        if (blank($projectCall->getTranslation('invite_email', 'fr', false)) && blank($projectCall->getTranslation('invite_email', 'en', false))) {
            $text = str_replace("[AAP]", $projectCall->toString(), __('email.offer_created.intro'));
            $message = $message->line($text);
        } else {
            $text = [
                $projectCall->getTranslation('invite_email', 'fr', useFallbackLocale: false),
                $projectCall->getTranslation('invite_email', 'en', useFallbackLocale: false)
            ];
            $text = implode("<hr/>", array_unique(array_filter($text, fn($t) => filled($t))));
            $text = str_replace("[AAP]", $projectCall->toString(), $text);
            $message = $message->greeting(null)
                ->line($text);
        }

        return $message->action(__('email.offer_created.action'), route('home'))
            ->line(__('email.offer_created.outro'));
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
