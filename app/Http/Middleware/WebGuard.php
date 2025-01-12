<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Symfony\Component\HttpFoundation\Response;

class WebGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (!$user) return $this->logout($request);


        $session_token = $request->session()->get('access_token', '');
        $token_details = explode("|", $session_token);
        
        $access_token = $user->tokens()->where([
                            ["id", "=", $token_details[0] ?? 0],
                            ["token", "=", hash('sha256', $token_details[1] ?? "")],
                            ["expires_at", ">=", Carbon::now()],
                        ])->first();
        if (!$access_token) return $this->logout($request);
        
        $access_token->update(["expires_at" => Carbon::now()->addMinutes(15)]);

        $user->load(["role", "role.permissions"]);

        Context::add('user', $user);
        return $next($request);
    }

    private function logout($request) {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
