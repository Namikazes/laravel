<?php

namespace App\Notifications;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Services\Contract\InvoiceServicesContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class OrderCreateNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected InvoiceServicesContract $invoiceServices)
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
    public function toMail(Order $order): MailMessage
    {
        logs()->info(self::class);

        $invoice = $this->invoiceServices->ganerete($order);

        return (new MailMessage)
                    ->greeting("Hello, $order->name $order->surname ")
                    ->line("Your order was create!")
                    ->lineIf(
                        $order->status->name === OrderStatus::Paid->value,
                        "And successfully  paid"
                    )
                    ->line("You can see your order in invoice")
                    ->attach(
                        Storage::disk('public')->path($invoice->filename),
                        [
                            'as' => $invoice->filename,
                            'mine' => 'application/pdf'
                        ]
                    )
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
            //
        ];
    }
}
