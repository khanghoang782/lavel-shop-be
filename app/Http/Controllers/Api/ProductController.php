<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function getAll()
    {
        $data = DB::table("products")
            ->join('catalogs', 'catalogs.id', '=', 'products.catalog_id')
            ->select('products.id', 'product_name','description','price','stock','catalogs.catalog_name')
            ->paginate(9);

        return response()->json([$data],200);
    }
    public function getAllCatalogs(){
        $data=DB::table("catalogs")->select('catalogs.id','catalogs.catalog_name')->get();
        return response()->json(['data'=>$data],200);
    }
    public function getByCatalogId(Request $request)
    {
        $catalog_id = $request->route()->parameter('catalog_id');

        $data = DB::table("products")
            ->join('catalogs', 'catalogs.id', '=', 'products.catalog_id')
            ->select('products.id', 'product_name','description','price','stock','catalogs.catalog_name')
            ->where('catalogs.id', '=', $catalog_id)
            ->paginate(12);
        return response()->json([$data],200);
    }
    public function getOneProductById(Request $request){
        $id = $request->route()->parameter('product_id');
        $data = DB::table("products")
            ->join('catalogs', 'catalogs.id', '=', 'products.catalog_id')
            ->select('products.id', 'product_name','description','price','stock','catalogs.catalog_name')
            ->where('products.id', '=', $id)
            ->firstOrFail();
        return response()->json(['data'=>$data],200);
    }
    public function getRandomProduct(Request $request){
        $sort=$request->query('sort');
        if($sort=='random'){
            $data = DB::table("products")
                ->select('id', 'product_name','price')
                ->inRandomOrder()->limit(8)->get();
            return response()->json(['data'=>$data],200);
        }
        if($sort=='new'){
            $data = DB::table("products")
                ->select('id', 'product_name','price')
                ->latest()->limit(8)->get();
            return response()->json(['data'=>$data],200);
        }
        if(is_numeric($sort)){
            $data = DB::table("products")
                ->join('catalogs', 'catalogs.id', '=', 'products.catalog_id')
                ->select('products.id', 'product_name','description','price','stock')
                ->where('catalogs.id', '=', $sort)
                ->orderBy('products.created_at','desc')->limit(8)->get();
            return response()->json(['data'=>$data],200);
        }
        return response()->status(400);

    }



}
