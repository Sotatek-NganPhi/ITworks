<?php

namespace App\Listeners;

use App\Events\CriteriaChangedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CriteriaChangedEventListener implements ShouldQueue
{
    use InteractsWithQueue;

    public $model;

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
     * @param  CriteriaChangedEvent  $event
     * @return void
     */
    public function handle(CriteriaChangedEvent $event)
    {
        $this->model = $event->model;
        app('rankingservice')->updateOne($this->model);
    }
}
