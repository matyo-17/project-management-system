<?php

namespace App\Http\Controllers;

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

    public function authenticate(Request $request) {
        $validator = Validator::make($request->input(), [
            "username" => ["required"],
            "password" => ["required"],
        ]);

        if ($validator->fails()) {
            return redirect("/login")->withErrors("Please fill in username and password.");
        }

        $credentials = $validator->validated();
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

    public function sign_up(Request $request) {
        $validator = Validator::make($request->input(), [
            "email" => ["required", "email", "unique:users,email"],
            "username" => ["required", "min:5", "unique:users,username"],
            "name" => ["required", "max:255"],
            "password" => ["required", "min:6", "confirmed"],
        ]);
        if ($validator->fails()) {
            return redirect("/register")->withErrors($validator->errors()->first());
        }

        $validated = $validator->validated();

        $role = Roles::find_by_name("user");

        $user = new User;
        $user->username = $validated["username"];
        $user->name = $validated["name"];
        $user->email = $validated["email"];
        $user->password = $validated["password"];
        $user->role()->associate($role);
        $user->save();

        return redirect('/login');
    }
}
