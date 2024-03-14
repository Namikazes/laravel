<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\User;
use App\Notifications\AdminOrderCreateNotification;
use App\Notifications\OrderCreateNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class OrderCreateNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Order $order)
    {
        $this->onQueue('notifications');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        logs()->info(__CLASS__ . ": Notify customer");

        $this->order->notify(app()->make(OrderCreateNotification::class));

        logs()->info(__CLASS__ . ": Notify admins");
        Notification::send(
            User::role('admin')->get(),
            app()->make(AdminOrderCreateNotification::class, ['order' => $this->order])
        );
    }
}
