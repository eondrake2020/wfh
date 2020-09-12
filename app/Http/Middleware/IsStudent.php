<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class IsStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->role === 'STUDENT') {
            return $next($request);
        }
        return redirect()->back();
    }
}
