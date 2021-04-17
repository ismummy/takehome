<?php

namespace App\Listeners;

use App\Services\SubscriptionService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DispatchTopic
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        foreach ($event->sub as $sub) {
            (new SubscriptionService)->notify($sub, $event->payload);
        }
    }
}
