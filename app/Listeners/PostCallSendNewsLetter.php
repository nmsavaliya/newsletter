<?php

namespace App\Listeners;

use App\Events\PostCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Artisan;

class PostCallSendNewsLetter implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PostCreatedEvent  $event
     * @return void
     */
    public function handle(PostCreatedEvent $event)
    {
        Artisan::call("command:SentEmailToSubscriberCommand ".$event->post->id);
    }
}
