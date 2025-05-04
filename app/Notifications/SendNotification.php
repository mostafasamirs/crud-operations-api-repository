<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $notification;
    protected $channels;

    /**
     * Create a new notification instance.
     */
    public function __construct($notification,array $channels)
    {
        $this->notification = $notification;
        $this->channels = $channels;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return $this->channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->notification->title)
            ->line($this->notification->body)
            ->action('View Notification', $this->notification->url);
    }

    public function toSms($notifiable)
    {
        return $this->notification->body;
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->notification->title,
            'body' => $this->notification->body,
            'url' => $this->notification->url,
        ];
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
