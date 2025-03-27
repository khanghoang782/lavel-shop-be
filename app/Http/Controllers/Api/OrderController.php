<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OrdersConfirmMail;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Mailtrap\Exception\MailtrapExceptionInterface;

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
       $cartItem=DB::table('order_details')
            ->join('products','order_details.product_id','=','products.id')
            ->where('order_details.order_id','=',$order_id)
            ->select('order_details.order_id','products.product_name','order_details.quantity','products.price');
        $cartArray=array($cartItem);
        try{
            //Testing email
            Mail::to('pnhkhang92vp2@gmail.com')->send(new OrdersConfirmMail($cartArray));
        }catch (MailtrapExceptionInterface $exception){
            return response()->json(['message'=>$exception->getMessage()],500);
        }
        return response()->json(['data'=>$oder],200);
    }
    public function testCardMail(){
        $cartItem=DB::table('order_details')
            ->select('order_details.order_id','products.product_name','order_details.quantity','products.price')
            ->join('products','products.id','=','order_details.product_id')
            ->where('order_details.order_id','=',1)
            ->get();
        $cartArray=array($cartItem);
        try{
            Mail::to('pnhkhang92vp2@gmail.com')->send(new OrdersConfirmMail($cartArray));
        }catch (MailtrapExceptionInterface $exception){
            return response()->json(['message'=>$exception->getMessage()],500);
        }
        return response()->json($cartItem,200);
    }
}
