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

        $event = Event::find($request->route()->parameter('event'));

        if (!auth()->user()->events->contains($event)) {
            abort(403);
        }

        return $next($request);
    }
}
