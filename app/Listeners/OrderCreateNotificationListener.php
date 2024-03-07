<?php

namespace App\Listeners;

use App\Events\OrderCreateEvent;
use App\Jobs\OrderCreateNotificationJob;

class OrderCreateNotificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreateEvent $event): void
    {
        OrderCreateNotificationJob::dispatch($event->order);
    }
}
