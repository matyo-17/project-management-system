<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\Crypt;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class ApiGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $access_token = str_replace("Bearer ", "", $request->header('authorization', ""));
        
        try {
            $plain = Crypt::decryptString($access_token);
        } catch (Exception $e) {
            $plain = "";
        }
        
        $token_details = explode("|", $plain);
        $token = PersonalAccessToken::where([
                    ["id", "=", $token_details[0] ?? ""],
                    ["token", "=", $token_details[1] ?? ""],
                    ["expires_at", ">", Carbon::now()],
                ])->first();
        if (!$token) return abort(401);

        $user = $token->tokenable;

        Context::add('user', $user);
        return $next($request);
    }
}
