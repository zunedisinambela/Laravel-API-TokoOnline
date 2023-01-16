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
    public function products(Request $request)
    {
        $query = Product::with(['latestImage'])->orderBy('product', 'asc');

        if ($request->search != null) {
            $query->where('product', 'like', '%'. $request->search.'%');
        }

        $product = $query->paginate(10);

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
