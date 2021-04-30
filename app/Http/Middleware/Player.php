<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Player
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    protected $redirectTo;
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role == 1) {
            return redirect()->route('superadmin');
        }
        
        if (Auth::user()->role == 3) {
            return $next($request);
        }

        if (Auth::user()->role == 2) {
            return redirect()->route('admin');
        }
    }
}
