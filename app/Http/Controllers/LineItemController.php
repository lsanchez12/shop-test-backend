<?php

namespace App\Http\Controllers;

use App\Models\LineItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LineItemController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'product_id' => ['required', 'integer'],
                'quantity' => ['required', 'integer','max:5', 'min:1'],
                'uuid' => ['required'],
            ]);

            if($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Invalid request', 'errors' => $validator->errors()], 500);
            }

            if(!$order = Order::select("id")->whereUuid($request->uuid)->first()){
                return response()->json(['status' => false, 'message' => 'Order not found'], 400);
            }

            if(!$lineItem = LineItem::whereProductId($request->product_id)->whereOrderId($order->id)->first()){
                LineItem::create([
                    "order_id" => $order->id,
                    "product_id" => $request->product_id,
                    "quantity" => $request->quantity,
                ]);
            }
            else{
                $lineItem->quantity = $lineItem->quantity + $request->quantity;
                $lineItem->save();
            }

            return response()->json(['status' => true], 201);
         } catch (\Throwable $e) {
             \Log::info($e);
             return response()->json(['status' => false, 'message' => 'Invalid request', 'errors' => $e->getMessage()], 500);
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LineItem  $lineItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(LineItem $lineItem){
        try {
            $lineItem->delete();
            return response()->json(['status' => true], 200);
        } catch (\Throwable $e) {
            \Log::info($e);
            return response()->json(['status' => false, 'message' => 'Invalid request', 'errors' => $e->getMessage()], 500);
        }
    }
}
