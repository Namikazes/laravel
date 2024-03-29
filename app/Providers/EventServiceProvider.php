<?php

namespace App\Providers;

use App\Events\OrderCreateEvent;
use App\Listeners\OrderCreateNotificationListener;
use App\Listeners\UserLoginListener;
use App\Listeners\UserLogoutListener;
use App\Models\Image;
use App\Models\Product;
use App\Observers\ImageObserver;
use App\Observers\ProductObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \Illuminate\Auth\Events\Logout::class => [
            UserLogoutListener::class
        ],
        \Illuminate\Auth\Events\Login::class => [
            UserLoginListener::class
        ],
        OrderCreateEvent::class => [
            OrderCreateNotificationListener::class
        ]
    ];

    protected $observers = [
      Image::class => ImageObserver::class,
        Product::class => ProductObserver::class
    ];
    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
