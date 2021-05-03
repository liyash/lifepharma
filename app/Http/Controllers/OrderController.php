<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\User;
use App\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where(["status" => 1, "processed" => 0])->get();
        return view('orders.list', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        return view('orders.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = new Order();
        $order->items = $request->items;
        $order->total = $request->total;
        $order->save();
        return redirect()->to('/orders');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!($order = Order::find($id)))
            throw new ModelNotFoundException('Model Not found!');

        $order->delete();

        return redirect()->route('list.orders');
    }

    public function view(Request $request)
    {
        $orders = Order::find($request->id);
        $orderCostArray = ($orders->orderdetails->pluck("product.price"));
        $orderCost = 0;
        foreach ($orderCostArray as $key => $value) {
            $orderCost = $orderCost + $value;
        }
        return view('orders.show', compact('orders', "orderCost"));
    }

    public function processOrder(Request $request)
    {
        $order = Order::find($request->id)->update(['processed' => 1]);

        if ($order) {
            $returnData = [
                "status_code" => 200,
                "data" => [],
                "message" => "Processed Successfully"
            ];
        } else {
            $returnData = [
                "status_code" => 401,
                "data" => [],
                "message" => "Not Processed "
            ];
        }
        return response()->json($returnData);
    }
}
