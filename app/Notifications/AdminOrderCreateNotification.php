<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class AdminOrderCreateNotification extends Notification
{
    use Queueable;

    public function __construct(public Order $order) {}

    public function via(object $notifiable): array
    {
        return $notifiable->telegram_id ? ['telegram'] : ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        logs()->info(__METHOD__);

        return (new MailMessage)
            ->greeting("Hello, $notifiable->name $notifiable->surname")
            ->line("You have a new order!");
    }

    public function toTelegram(object $notifiable)
    {
        logs()->info(__METHOD__);
        $url = route('admin.dashboard');

        return TelegramMessage::create()
            ->to($notifiable->telegram_id)
            ->content("Hello there!")
            ->line("You have a new order!")
            ->line("Check it in admin panel!")
            ->button('Return dashboard', $url);
    }

}
