<?php

namespace App\Providers;

//use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\PostPublishedEvent;
use App\Listeners\SendPostNotificationListener;
class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PostPublishedEvent::class => [
            SendPostNotificationListener::class,
        ],
    ];
    
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        parent::boot();
    }
}
