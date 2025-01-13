<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile(Request $request) {
        return view("pages.profile");
    }

    public function update(ProfileUpdateRequest $request) {
        $validated = $request->validated();
        $user = Context::get("user");

        if (!$validated['password']) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
            $user->tokens()->delete();
        }

        $user->update($validated);

        $this->result['status'] = "success";
        return response()->json($this->result);
    }
}
