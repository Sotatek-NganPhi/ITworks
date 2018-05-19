<?php

namespace App\Http\Middleware;

use Auth;
use Log;
use Closure;
use SQSLogger;
use Illuminate\Http\Request;

class AccessLogging
{
    public function handle(Request $request, Closure $next)
    {
        $userId = null;
        if (Auth::check()) {
            $userId = auth()->user()->userId;
        }

        $message = json_encode([
            'time' => date('Y-m-d H:i:s'),
            'userId' => $userId,
            'method' => $request->method(),
            'accessUrl' => $request->fullUrl()
        ], JSON_UNESCAPED_SLASHES);

        Log::debug("ACCESS {$message}");
        return $next($request);
    }
}
