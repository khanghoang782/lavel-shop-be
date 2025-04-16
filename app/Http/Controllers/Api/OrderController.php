<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Mail\OrdersConfirmMail;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Mailtrap\Exception\MailtrapExceptionInterface;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrderController extends Controller
{
    public function makeOrder(Request $request){

        //$oderinfo=$request->input('customer');
        try{
            $user=JWTAuth::parseToken()->authenticate();
            if($user){
                $cartData=$request->input('cart');
                $order=Order::create([
                    'name'=>$request->input('customer.name'),
                    'created_by'=>$user->id,
                    'email'=>$request->input('customer.email'),
                    'phone'=>$request->input('customer.phone_number'),
                    'address'=>$request->input('customer.address')
                ]);
                $order_id=$order->id;
                foreach ($cartData as $cartItem){
                    OrderDetail::create([
                        'order_id'=>$order_id,
                        'created_by'=>$user->id,
                        'product_id'=>$cartItem['product_id'],
                        'type'=>$cartItem['attribute'],
                        'quantity'=>$cartItem['quantity'],
                    ]);
                }
                $cartItem=DB::table('order_details')
                    ->join('products','order_details.product_id','=','products.id')
                    ->where('order_details.order_id','=',$order_id)
                    ->select('order_details.order_id','products.product_name','order_details.quantity','products.price');
                //$cartArray=array($cartItem);
                /* try{
                     //Testing email
                     Mail::to('pnhkhang92vp2@gmail.com')->send(new OrdersConfirmMail($cartArray));
                 }catch (MailtrapExceptionInterface $exception){
                     return response()->json(['message'=>$exception->getMessage()],500);
                 }*/
                return response()->json($order,200);
            }
        }catch (JWTException $e) {
            return ResponseHelper::error(message: "Invalid token", statusCode: 400);
        }
        return response()->json(['message'=>'Invalid token'], 400);
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
    public function getOrderDetails(Request $request){
        $orderId=$request->route()->parameter('id');
        $order=Order::where('id',$orderId)->first();
        if($order){
            $cartItem=DB::table('order_details')
                ->select('order_details.order_id','products.id','products.product_name','order_details.quantity','products.price')
                ->join('products','products.id','=','order_details.product_id')
                ->where('order_details.order_id','=',$orderId)
                ->get();
            return response()->json(['order'=>$order,'cart'=>$cartItem],200);
        }
        return response()->json(['message'=>'Order not found'],404);

    }
    public function createProductFeedback(Request $request){
        $product_id=$request->route()->parameter('id');
        try{
            $user=JWTAuth::parseToken()->authenticate();
            if($user){
                $order=OrderDetail::where('product_id','=',$product_id)->where('created_by','=',$user->id)->firstOrFail();
                if($order){
                    $feedback=ProductFeedback::create([
                        'of_product'=>$product_id,
                        'created_by'=>$user->id,
                        'rating'=>$request->input('rating'),
                        'feedback'=>$request->input('feedback')
                    ]);
                }
                return response()->json(200,200);
            }
        }catch (JWTException $e) {
            return ResponseHelper::error(message: "Invalid token", statusCode: 400);
        }

        return response()->json('',200);
    }
}
