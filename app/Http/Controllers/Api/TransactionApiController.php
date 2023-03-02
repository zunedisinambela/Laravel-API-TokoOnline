<?php

namespace App\Http\Controllers\Api;

use DB;
use Auth;
use Response;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\DetailsTransaction;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;

class TransactionApiController extends Controller
{
    public function index()
    {
        $tra = Transaction::with('userRelation')->paginate(10);

        if ($tra->isEmpty()) {
            return Response::json([
                'status' => [
                    'code' => 404,
                    'description' => 'Not Found'
                ]
            ],404);
        }

        return TransactionResource::collection($tra)->additional([
            'status' => [
                'code' => 200,
                'description' => 'Not Found',
            ]
        ])->response()->setStatusCode(200);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // insert-header
            $tr = new Transaction();
            $tr->transaction_code = Transaction::GetCode();
            $tr->user_id = $request->user_id;
            $tr->destination = $request->destination;
            $tr->ongkir = $request->ongkir;
            $tr->grandtotal = $request->grandtotal;
            $tr->save();

            foreach ($request->detail as $detail) {
                $product = Product::where('id', $detail['product_id'])->first();

                if ($product->stock <= $detail['qty']) {
                    DB::rollback();

                    return Response::json([
                        'status' => [
                            'code' => 403,
                            'description' => "$product->product Melebihi Stock"
                        ]
                    ]);
                }

                // detail-transaction
                $dtl = new DetailsTransaction();
                $dtl->transaction_id = $tr->id;
                $dtl->product_id = $detail['product_id'];
                $dtl->product = $product->product;
                $dtl->qty = $detail['qty'];
                $dtl->price = $detail['price'];
                $dtl->total = $detail['total'];
                $dtl->save();

                $product->decrement('stock', $detail['qty']);
            }

            DB::commit();

            return Response::json([
                'status' => [
                    'code' => 201,
                    "description" => "Data Transaksi Berhasil dibuat"
                ]
            ],201);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            throw $th;
        }
    }

    public function detail($code)
    {
        $tr = Transaction::with(['userRelation', 'detailRelation'])->where('transaction_code', $code)->first();

        if ($tr == null) {
            return Response::json([
                "status" => [
                    "code" => 404,
                    "description" => "Not Found"
                ]
            ],404);
        }

        return (New TransactionResource($tr))->additional([
            "status" => [
                "code" => 200,
                "description" => "OK"
            ]
        ])->response()->setStatusCode(200);
    }

    public function byuser($iduser, $status = null)
    {
        $query = Transaction::with('userRelation')->where('user_id', $iduser);

        if ($status != null){
            if ($status == 'unpaid') {
                $query->whereIn('status_transaction', ['waiting', 'pending']);
            } elseif($status == 'paid'){
                $query->whereIn('status_transaction', ['process', 'send']);
            }
        }

        $tr = $query->paginate(10);

        if ($tr == null) {
            return Reponse::json([
                'status' => [
                    'code' => 404,
                    'description' => "Not Found"
                ]
            ], 404);
        }

        return TransactionResource::collection($tr)->additional([
            'status' => [
                'code' => 200,
                'description' => 'Ok'
            ]
        ])->response()->setStatusCode(200);
    }

    public function upload(Request $request, $code)
    {
        $tr = Transaction::where('transaction_code', $code)->first();

        if ( $tr == null ) {
            return Response::json([
                'status' => [
                    'code' => 404,
                    'description' => 'Not Found'
                ]
            ], 404);
        }

        if ( ! $request->hasFile('bukti')) {
            return Response::json([
                'status' => [
                    'code' => 403,
                    'description' => "Bad Request"
                ]
            ], 403);
        }

        $path = $request->file('bukti')->store('transaction');

        $tr->update([
            'proof_of_payment' => $path,
            'status_transaction' => 'pending',
        ]);

        return Response::json([
            'status' => [
                'code' => 202,
                'description' => 'Updated Accepted'
            ]
        ], 202);
    }
}
