<?php

namespace App\Http\Middleware;

use App\Lib\Clearance;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Symfony\Component\HttpFoundation\Response;

class PermissionGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Context::get("user");
        $clearance = new Clearance($user);

        Context::add("clearance", $clearance);
        view()->share("clearance", $clearance);
        return $next($request);
    }
}
