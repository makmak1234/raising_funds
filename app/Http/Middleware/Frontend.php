<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Frontend
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
        if (!Auth::guard("investors")->check())
            return redirect("/private/auth_investor");

        // $user = Auth::guard('clients')->user();
        // $token = str_random(100);
        // $user->update([
        //     "token"         => $token,
        //     "token_expired" => Carbon::now()->addMinutes(config("app.token_expired"))
        // ]);

        return $next($request);
    }
}