<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (!\Auth::attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $accessToken = $tokenResult->token;

        return response([
            'user' => [
                "user_id" => $user->id,
                "name" => $user->name,
                "username" => $user->username,
                "email" => $user->email,
                'access_token' => $tokenResult->accessToken
            ]
        ]);
    }
}
