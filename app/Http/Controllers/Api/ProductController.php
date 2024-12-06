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
        return response()->json([$data],200);
    }
    public function getByCatalogName(Request $request)
    {
        $catalog_name = $request->route()->parameter('catalog_name');

        $data = DB::table("products")
            ->join('catalogs', 'catalogs.id', '=', 'products.catalog_id')
            ->select('products.id', 'product_name','description','price','stock','catalogs.id','catalogs.catalog_name')
            ->where('catalogs.catalog_name', '=', $catalog_name)
            ->paginate(9);
        return response()->json([$data],200);
    }
    public function getOneProductById(Request $request){
        $id = $request->route()->parameter('product_id');
        $data = DB::table("products")
            ->join('catalogs', 'catalogs.id', '=', 'products.catalog_id')
            ->select('products.id', 'product_name','description','price','stock','catalogs.id','catalogs.catalog_name')
            ->where('products.id', '=', $id)
            ->firstOrFail();
        return response()->json(['data'=>$data],200);
    }
}
