<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;
use Illuminate\Support\Facades\Auth;

class RegisterCandidateInformation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user = Auth::guard($guard)->user();
        $route = $request->route()->getName();
        $isIgnore = $route === 'candidate.create' || $route === 'candidate.store';

        if (Auth::guard($guard)->check()) {
            if (!$user->candidate && !$isIgnore) {
                return Redirect::route('candidate.create');
            }


            if ($user->candidate && $isIgnore) {
                return redirect('/home');
            }
        }

        return $next($request);
    }
}
