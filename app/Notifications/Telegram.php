<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class Telegram extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected $data, protected $view, protected $keyboardtext = null, protected $keyboardurl = null)
    {
        $this->data = $data;
        $this->view = $view;
        $this->keyboardtext = $keyboardtext;
        $this->keyboardurl = $keyboardurl;
    }


     /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

    public function toTelegram(object $notifiable): TelegramMessage
    {
        if (isset($this->keyboardtext) && isset($this->keyboardurl)) {
            return TelegramMessage::create()->view($this->view, $this->data)->to($notifiable->telegram_id)->buttonWithCallback($this->keyboardtext, $this->keyboardurl);
        } else {
            return TelegramMessage::create()->view($this->view, $this->data)->to($notifiable->telegram_id);
        }
    }
}
