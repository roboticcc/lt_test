<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CheckIfLoggedIn
{
    /**
     * Handle an incoming request and checks if user is logged in
     */
    public function handle(Request $request, Closure $next): Renderable
    {
        if (!Auth::user()) {
            abort(403);
        }

        return $next($request);
    }
}
