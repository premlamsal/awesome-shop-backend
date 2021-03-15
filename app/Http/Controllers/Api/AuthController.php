<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [

            'firstname'     => 'required|max:55',

            'lastname'     => 'required|max:55',
            
            'email'    => 'email|required|unique:users',
            // 'password' => 'required|confirmed',
            'password'=>'required'

        ]);


        $user=new User();

        $user->password = bcrypt($request->password);

        $user->firstname=$request->firstname;

        $user->lastname=$request->lastname;

        $user->user_type="user";
        
        $user->email=$request->email;

        $user->balance="0";

        $user->save();

        if($user){
            
            $accessToken = $user->createToken('authToken')->accessToken;
            return response(['user' => $user, 'access_token' => $accessToken]);
        }
        else{
           return response(['status' => 'error', 'message' => 'failed creating new user. #UUR01']);
        }
    }
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email'    => 'email|required',
            'password' => 'required',
        ]);

        if (auth()->attempt($loginData) && auth()->user()->user_type == 'user') {
            $accessToken = auth()->user()->createToken('authToken')->accessToken;
            return response(['user' => auth()->user(), 'access_token' => $accessToken]);
        } else {
            //not admin or invalid email and password
            return response(['message' => 'Sorry!! Invalid Email or Password'],401);
        }

    }

    public function logout (Request $request) 
    {
    $token = $request->user()->token();
    $token->revoke();
    $response = ['message' => 'You have been successfully logged out!'];
    return response($response, 200);
    }
}
