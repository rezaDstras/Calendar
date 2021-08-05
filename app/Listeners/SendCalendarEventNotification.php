<?php

namespace App\Listeners;

use App\Events\NewCalendarEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCalendarEventNotification
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
     * @param  NewCalendarEvent  $event
     * @return void
     */
    public function handle(NewCalendarEvent $event)
    {
        //
    }
}
