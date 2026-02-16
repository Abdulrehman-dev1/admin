<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UpdateUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (Auth::check()) {
                \Illuminate\Support\Facades\DB::table('users')
                    ->where('id', Auth::id())
                    ->update(['last_active_at' => now()]);
            }
        } catch (\Exception $e) {
            \Log::error("Activity Middleware Error: " . $e->getMessage());
        }

        return $next($request);
    }
}
