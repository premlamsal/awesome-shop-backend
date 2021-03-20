<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Order;
use Auth;
use App\Http\Resources\Order as ResourcesOrder;

class OrderController extends Controller
{

    public function myOrders(){

    	$user_id=Auth::user()->id;

        $order=Order::where('user_id',$user_id)->orderBy('id', 'DESC'); 
        
        return ResourcesOrder::collection($order->get());

    }
    public function show($id){
        
        $user_id=Auth::user()->id;

        $order=Order::where('id',$id)->where('user_id',$user_id)->orderBy('id', 'DESC'); 
        
        return ResourcesOrder::collection($order->get());

    }
    
}
