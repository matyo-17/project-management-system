<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Guard $auth): void
    {

        View::composer('*', function ($view) use ($auth) {
            $user = $auth->user();

            $access_token = "";
            if ($user) {
                $token = $user->tokens()->first();
                $access_token = "Bearer ".Crypt::encryptString($token->id."|".$token->token."|".$token->expires_at);
            }
            
            $view->with('user', $user);
            $view->with('access_token', $access_token);
        });
    }
}
