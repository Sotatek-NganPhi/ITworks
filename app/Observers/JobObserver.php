<?php

namespace App\Observers;


use App\Models\Job;
use Illuminate\Support\Facades\Cache;

class JobObserver
{
    public function created(Job $job)
    {
        Cache::tags('search')->forget();
    }

    public function updated(Job $job)
    {
        Cache::tags('search')->forget();
    }

    public function saved(Job $job)
    {
        Cache::tags('search')->forget();
    }

    public function deleting(Job $job)
    {
        Cache::tags('search')->forget();
    }
}