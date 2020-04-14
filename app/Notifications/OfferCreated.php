<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OfferCreated extends Notification
{
    use Queueable;

    private $projectcall;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($projectcall)
    {
        $this->projectcall = $projectcall;
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
        $message = (new MailMessage)->subject(__('email.offer_created.title'));

        if (empty($this->projectcall->invite_email_fr) && empty($this->projectcall->invite_email_en)) {
            $text = str_replace("[AAP]", $this->projectcall->toString(), __('email.offer_created.intro'));
            $message = $message->line($text);
        } else {
            $text = [($this->projectcall->invite_email_fr ?? null), ($this->projectcall->invite_email_en ?? null)];
            $text = implode("<hr/>", array_filter($text));
            $text = str_replace("[AAP]", $this->projectcall->toString(), $text);
            $message = $message->greeting(null)
                ->line($text);
        }

        return $message->action(__('email.offer_created.action'), url('/'))
            ->line(__('email.offer_created.outro'));
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
