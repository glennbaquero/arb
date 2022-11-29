<?php

namespace App\Notifications\Admin\Documents;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RejectionMessageNotification extends Notification
{
    use Queueable;

    protected $item;
    protected $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($item, $message)
    {
        $this->item = $item;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject(config('app.name') . ': Document Rejected')
                    ->greeting('Hello ' . $notifiable->renderName() . ',')
                    ->line('Your uploaded document in ARB has been rejected, we provided here the rejection message.')
                    ->line($this->message);
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
            'message' => 'Your uploaded document in ARB has been rejected, we provided here the rejection message. '.$this->message,
            'title' => 'Rejected Document',
            'subject_id' => $notifiable->id, 
            'subject_type' => get_class($notifiable),
        ];
    }
}
