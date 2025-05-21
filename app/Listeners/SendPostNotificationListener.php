<?php

namespace App\Listeners;

use App\Events\PostPublishedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\NewPostNotificationMail;
use App\Models\User as Subscriber;
use Illuminate\Support\Facades\Mail;

class SendPostNotificationListener
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
    public function handle(PostPublishedEvent $event): void
    {
        $subscribers = Subscriber::where('is_active', 1)
            ->where('is_admin', 0)
            ->get(['name', 'email']);

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->queue(new NewPostNotificationMail(
                $event->post, 
                $subscriber->name, 
                config('app.url') // Website URL
            ));
        }
    }
}
