<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\Order as ResourcesOrder;
use App\Order;
use App\OrderDetail;
use Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function createOrder(Request $request)
    {
        $user_id = Auth::user()->id;
        
          //collecting data
          $items = collect($request->all())->transform(function ($item) {
            $item['line_total'] = $item['bookQuantity'] * ($item['bookPrice']-$item['bookDiscount']);
            return new OrderDetail($item);
        });
        if ($items->isEmpty()) {
            return response()
                ->json([
                    'items_empty' => 'One or more Item is required.',
                ], 422);
        }

        $order=new Order();
        $order->status='cart';
        $order->grand_total=$items->sum('line_total');
        $order->user_id=$user_id;
        $order->save();

        foreach ($request->all() as $temp) {
            $orderDetail=new OrderDetail();
            $orderDetail->order_id=$order->id;
            $orderDetail->book_id=$temp['bookId'];
            //fetch price from db instead 
            $orderDetail->price=$temp['bookPrice'];
            $orderDetail->quantity=$temp['bookQuantity'];
            $orderDetail->image=$temp['bookImage'];
            $orderDetail->name=$temp['bookName'];
            $orderDetail->discount=$temp['bookDiscount'];
            $orderDetail->line_total=($temp['bookPrice'] -$temp['bookDiscount']) * $temp['bookQuantity'];
            $orderDetail->save();
        }   
        return response()->json(['amount'=>$order->grand_total,'product_id'=>$order->id]);
    }
    public function myOrders()
    {

        $user_id = Auth::user()->id;

        $order = Order::where('user_id', $user_id)->where('status','!=','cart')->orderBy('id', 'DESC');

        return ResourcesOrder::collection($order->get());

    }
    public function orders()
    {
        // //this will return order created by other customer and should displayed on owner of book account

        /*

         */
        $user_id = Auth::user()->id;

        $orders = Order::whereHas('orderDetail.book', function ($query) use ($user_id) {
            $query->where('user_id', '=', $user_id);
        })->get();

        // will get you orders that have products by this seller

        return ResourcesOrder::collection($orders);

    }
    public function show($id)
    {

        $user_id = Auth::user()->id;

        $order = Order::where('id', $id)->where('user_id', $user_id)
                       ->with('orderDetail');

        // return ResourcesOrder::collection($order->get());
        return response()->json(['data'=>$order->get()]);

    }
    public function getSellerOrder($id)
    {

        $user_id = Auth::user()->id;

        if ($user_id != null) {
            $order = Order::where('id', $id)->orderBy('id', 'DESC');

            return ResourcesOrder::collection($order->get());
        }

    }

}
