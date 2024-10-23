<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactMessage extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected array $data)
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
            ->subject(__('email.contact.title'))
            ->replyTo($this->data['email'], $this->data['name'])
            ->line(__('email.contact.intro', [
                'type'                  => $this->data['visitor'] ? __('email.contact.type_visitor') : __('email.contact.type_user'),
                'name'                  => $this->data['name'],
                'email'                 => $this->data['email'],
                'oversight_affiliation' => $this->data['oversight_affiliation'],
                'message'               => $this->data['message'],
            ]))
            ->action(__('email.contact.action'), "mailto:" . $this->data['email']);
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
