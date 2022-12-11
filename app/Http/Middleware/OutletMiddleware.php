<?php

namespace App\Http\Middleware;

use App\Models\Outlet;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OutletMiddleware
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
        $params = $request->route()->parameters();
        if (isset($params['outlet_id'])) {
            $outlet = Outlet::find($params['outlet_id']);
            if ($outlet) {
                if (Auth::user()->id == $outlet->owner_id || Auth::user()->hasPermission('api.outlet.edit')) {
                    return $next($request);
                }
                return response()->json([
                    "status" => false,
                    "message" => "Anda tidak mempunyai izin untuk mengubah gerai ini",
                    "body" => [],
                ], 403);
            }
        }
        return response()->json([
            "status" => false,
            "message" => "Gerai tidak ditemukan",
            "body" => [],
        ], 404);
    }
}
