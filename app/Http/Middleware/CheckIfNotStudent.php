<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfNotStudent
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
        if(auth()->user()->type == 'S')
        {
           return $next($request);
        }
        else
        {
            return redirect()->back()->with('error','You are not authorised to access this page.');
             
        }
    }
}
