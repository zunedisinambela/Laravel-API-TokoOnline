<?php

namespace App\Http\Controllers\Api;

use DB;
use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function products()
    {
        $product = Product::paginate(10);

        if ($product->isEmpty()) {
            return Response::json([
                'status' => [
                    'code' => 404,
                    'description' => 'Data Not Found'
                ]
            ], 404);
        } else {
            return ProductResource::collection($product)->additional([
                'status' => [
                    'code' => 200,
                    'description' => 'Ok',
                ]
            ])->response()->setStatusCode(200);
        }
    }
}
