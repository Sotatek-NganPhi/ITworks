<?php

namespace App\Listeners;

use App\Events\CriteriaDeleteEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CriteriaDeleteEventListener
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
     * @param  CriteriaDeleteEvent  $event
     * @return void
     */
    public function handle(CriteriaDeleteEvent $event)
    {
        switch ($event->table) {
            case 'jobs':
                app('rankingservice')->deleteJob($event->modelId);
                break;
            case 'candidates':
                app('rankingservice')->deleteCandidate($event->modelId);
                break;
        }

    }
}
