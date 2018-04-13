<?php

namespace App\Listeners;

use App\Models\Config;
use App\Utils;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RefreshMasterdataCache implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  Event  $event
     * @return void
     */
    public function handle()
    {
        Cache::flush();
    }
}
