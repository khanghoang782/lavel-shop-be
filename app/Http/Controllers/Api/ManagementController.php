<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;


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
}
