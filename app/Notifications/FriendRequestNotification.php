<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class FriendRequestNotification extends Notification
{
    use Queueable;

    public $sender;
    public $action;

    // The constructor to initialize the sender and action
    public function __construct($sender, $action)
    {
        $this->sender = $sender;
        $this->action = $action;
    }

    // Determine how the notification should be delivered
    public function via($notifiable)
    {
        return ['database']; // We’ll use database notifications here
    }

    // Define the notification’s content for the database
    public function toDatabase($notifiable)
    {
        return [
            'sender_id' => $this->sender->id,
            'sender_name' => $this->sender->first_name . ' ' . $this->sender->last_name,
            'action' => $this->action, // "accepted", "declined", "removed"
        ];
    }
}
