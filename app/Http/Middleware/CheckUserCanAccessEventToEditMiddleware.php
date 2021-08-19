<?php

namespace App\Http\Middleware;

use App\Models\Event;
use Closure;
use Illuminate\Http\Request;

class CheckUserCanAccessEventToEditMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (!auth()->user()->events->contains($request->route()->parameter('event'))) {
            abort(403);
        }

        return $next($request);
    }
}
