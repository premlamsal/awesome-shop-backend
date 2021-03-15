<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    public function users(){
        
        $users=User::where('user_type','!=','admin')->paginate(8);

        return UserResource::collection($users);
    }
}
