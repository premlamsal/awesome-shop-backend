<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email'    => 'email|required',
            'password' => 'required',
        ]);

        if (auth()->attempt($loginData) && auth()->user()->user_type == 'admin') {
            $accessToken = auth()->user()->createToken('authToken')->accessToken;
            return response(['user' => auth()->user(), 'access_token' => $accessToken]);
        } else {
            //not admin or invalid email and password
            return response(['msg' => 'Sorry!! Invalid Email or Password']);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
