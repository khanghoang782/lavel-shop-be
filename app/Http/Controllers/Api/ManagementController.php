<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class ManagementController extends Controller
{
    public function getAllUsers(){
        $data = User::simplePaginate(9);

        return ResponseHelper::success(message: "found",data:$data);
    }
    public function deleteUser(Request $request){
        $id=$request->route()->parameter('user_id');

    }
    public function addProduct(ProductRequest $request){

        $product=(new Product)->create([
            'product_name'=>$request->input('product_name'),
            'description'=>$request->input('description'),
            'price'=>$request->input('price'),
            'stock'=>$request->input('stock'),
            'catalog_id'=>$request->input('catalog_id'),
        ]);
        return ResponseHelper::success(message: "Product created", data:$product);
    }
    public function deleteProductById(Request $request){
        try{
            $id=$request->route()->parameter('product_id');
            Product::destroy($id);
            return ResponseHelper::success(message: "Product deleted");
        }catch (\Exception $e){
            return ResponseHelper::error(message: "something went wrong",data:$e,statusCode: 500);
        }
    }
    public function isAdmin(){
        return response()->json(["OK"],200);
    }
    public function addProductImage(Request $request){
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'product_id'=>'required'
        ]);
        $filename=time().'_'.$request->input('product_id').'.'.$request->file('image')->extension();
        $path=$request->file('image')->storeAs('images',$filename, 'public');

        if($path!=false){
            $url=Storage::url($filename);
            $image=ProductImage::create([
                'product_id'=>$request->input('product_id'),
                'image_path'=>$path,
                'image_url'=>"/storage/images/".$filename,
                'image_name'=>$filename,
            ]);
            return response()->json(["data"=>$image],200);
        }
    }
    public function getOrderList(Request $request){
        $sort=$request->query('sort');
        if($sort=='get-all'){
            $result = DB::table('orders')
                ->select('id','email','name','phone','status')
                ->simplePaginate(8);

            return response()->json(["data"=>$result],200);
        }
        if($sort=='get-pending'){
            $result = DB::table('orders')
                ->select('id','email','name','phone','status')
                ->where('status','PENDING')
                ->simplePaginate(8);

            return response()->json(["data"=>$result],200);
        }
        if($sort=='get-confirm'){
            $result = DB::table('orders')
                ->select('id','email','name','phone','status')
                ->where('status','CONFIRM')
                ->simplePaginate(8);

            return response()->json(["data"=>$result],200);
        }

        return response("",404);
    }
    public function updateOrderStatus(Request $request){
        $id=$request->route()->parameter('order_id');
        $action=$request->query('action');
        if($action=='accept'){
            DB::table('orders')
                ->where('id',$id)
                ->update(['status'=>'CONFIRM','updated_at'=>now()]);
            return response('OK',200);
        }
        if($action=='cancel'){
            DB::table('orders')
                ->where('id',$id)
                ->update(['status'=>'CANCELLED','updated_at'=>now()]);
            return response('OK',200);
        }
        if($action=='end'){
            DB::table('orders')
                ->where('id',$id)
                ->update(['status'=>'DONE','updated_at'=>now()]);
            return response('OK',200);
        }
        return response('',404);
    }
}
