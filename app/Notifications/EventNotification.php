<?php

namespace App\Notifications;

use App\Models\Calendar;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EventNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Calendar $event;

    /**
     * Create a new notification instance.
     */
    public function __construct(Calendar $event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Upcoming Event: ' . $this->event->event_title)
                    ->line('You have an upcoming event on ' . $this->event->event_date)
                    ->line('Location: ' . ($this->event->event_location ?? 'N/A'))
                    ->action('View Event', url('/events/' . $this->event->id))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->event->event_title,
            'date' => $this->event->event_date,
            'location' => $this->event->event_location,
        ];
    }
}
