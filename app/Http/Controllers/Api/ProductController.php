<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Auth;

class ProductController extends Controller
{
    public function listProducts(Request $request)
    {
        $Products = Product::select('id', 'name', 'detail', 'price')->get();
        $returnData = [
            "status_code" => 200,
            "data" => $Products->toArray(),
            "message" => "Retrieved Successfully"
        ];
        return response()->json($returnData);
    }
}
