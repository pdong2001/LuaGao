<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle($request, Closure $next)
    {
        if (auth()->user()) {
            return $next($request);
        }
        return response()->json('Invalid Token', 401);
    }
}
