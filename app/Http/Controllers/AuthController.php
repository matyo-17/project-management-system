<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Roles;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request) {
        return Auth::check() ? redirect("/") : view('login');
    }

    public function register(Request $request) {
        return Auth::check() ? redirect("/") : view('register');
    }
    
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function authenticate(AuthenticateRequest $request) {
        $credentials = $request->validated();
        if (!Auth::attempt($credentials)) {
            return redirect("/login")->withErrors("Wrong username or password.");
        }
        
        $user = $request->user();
        $user->tokens()->delete();
        $access_token = $user->createToken('accessToken', ["*"], Carbon::now()->addMinutes(15))->plainTextToken;

        $request->session()->regenerate();
        $request->session()->put('access_token', $access_token);

        return redirect('/');
    }

    public function sign_up(RegisterRequest $request) {
        $validated = $request->validated();

        $role = Roles::where('name', 'user')->first();
        
        $user = new User;
        $user->username = $validated["username"];
        $user->name = $validated["name"];
        $user->email = $validated["email"];
        $user->password = $validated["password"];
        $user->status = 1;
        $user->role()->associate($role);
        $user->save();

        return redirect('/login');
    }
}
