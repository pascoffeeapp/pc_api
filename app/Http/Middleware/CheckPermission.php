<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $routeName = $request->route()->action["as"];

        if (auth()->check()) {
            $user = auth()->user();
            dd($user->hasPermission($routeName));
            if ($user->hasPermission($routeName)) {
                return $next($request);
            }
        }
        
        return response()->json([
            "status" => false,
            "message" => "Anda tidak miliki izin",
            "body" => []
        ], 403);
    }
}
