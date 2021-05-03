<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Order;
use App\OrderDetail;
use App\SalesTransaction;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function addToCart(Request $request)
    {
        $productId = $request->product_id;
        $noOfproducts = $request->count;
        $cartCollection = Order::where([
            "created_by" => \Auth::user()->id,
            "status" => 0
        ])->first();
        $cartId = 0;
        if (isset($cartCollection)) {
            $cartId = $cartCollection->id;
        } else {
            $newCart = Order::create([
                "created_by" => \Auth::user()->id,
                "status" => 0
            ]);
            $cartId = $newCart->id;
        }
        $cartEntry = OrderDetail::updateOrCreate(
            [
                "cart_id" => $cartId,
                "product_id" => $request->product_id
            ],
            [
                "cart_id" => $cartId,
                "product_id" => $request->product_id,
                "count" => $request->count
            ]
        );
        $orderDet = OrderDetail::select("product_id", "count")->where(["cart_id" => $cartId])->get();
        $returnArray = [];
        foreach ($orderDet as $orderDetail) {
            $returnArray[] = [
                "product_id" => $orderDetail->product_id,
                "count" => $orderDetail->count,
                "prod_obj" => [
                    "name" => $orderDetail->product->name,
                    "detail" => $orderDetail->product->detail,
                    "price" => $orderDetail->product->price
                ]
            ];
        }
        if ($cartEntry) {
            $returnData = [
                "status_code" => 200,
                "data" => $returnArray,
                "message" => "Retrieved Successfully"
            ];
        } else {
            $returnData = [
                "status_code" => 401,
                "data" => $returnArray,
                "message" => "Some Issue adding the product"
            ];
        }

        return response()->json($returnData);
    }

    public function associateOrdertransaction(Request $request)
    {
        $order_id = $request->order_id;
        $transaction_id = $request->transaction_id;
        $card_details = $request->card_details;
        $status = $request->status;
        $cartCollection = Order::find($order_id);
        if ($status == true && $cartCollection->status == 0) {
            $transactionComplete = SalesTransaction::create([
                "cart_id" => $order_id,
                "transaction_id" => $transaction_id . "-" . $order_id,
                "card_details" => $card_details,
                "status" => $status
            ]);
            if ($transactionComplete) {
                $cartCollection->status = 1;
                $cartCollection->save();
                $returnArray = [
                    "status_code" => 200,
                    "data" => [],
                    "message" => "Transaction completed"
                ];
            }
        } else {
            SalesTransaction::create([
                "cart_id" => $order_id,
                "transaction_id" => $transaction_id,
                "card_details" => $card_details,
                "status" => $status
            ]);
            $returnArray = [
                "status_code" => 401,
                "data" => [],
                "message" => "Some Issue in processing"
            ];
        }
        return response()->json($returnArray);
    }
}
