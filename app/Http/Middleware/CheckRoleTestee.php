<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;

class CheckRoleTestee
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
        $user = User::where('id', Auth::id())->first();

        if ($user->type === User::TYPE_TESTEE) {
            return $next($request);
        } else {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    }
}
