<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $credentials = [
            'uid' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::validate($credentials)) {
            $user = Auth::getLastAttempted();

            return [
                'user' =>  $user,
                'token' => $user->createToken($request->device_name)->plainTextToken
            ];
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
}
