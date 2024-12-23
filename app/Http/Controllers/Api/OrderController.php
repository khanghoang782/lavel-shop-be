<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function makeOrder(Request $request){
        $cartData=$request->input('cart');
        //$oderinfo=$request->input('customer');

        $oder=Order::create([
           'name'=>$request->input('customer.name'),
            'email'=>$request->input('customer.email'),
            'phone'=>$request->input('customer.phone_number'),
            'address'=>$request->input('customer.address')
        ]);
        $order_id=$oder->id;
        foreach ($cartData as $cartItem){
            OrderDetail::create([
                'order_id'=>$order_id,
                'product_id'=>$cartItem['product_id'],
                'quantity'=>$cartItem['quantity'],
            ]);
        }


        return response()->json(['data'=>$oder],200);
    }
}
