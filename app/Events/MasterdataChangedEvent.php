<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class MasterdataChangedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
}