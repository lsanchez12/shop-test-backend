<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        try {
            return response()->json(['status' => true, 'orders' => Order::with('user','line_items','line_items.product')->paginate(15)], 200);
         } catch (\Throwable $e) {
             \Log::info($e);
             return response()->json(['status' => false, 'message' => 'Invalid request', 'errors' => $e->getMessage()], 400);
         }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        try {
            $order = Order::create([
                'user_id' => $request->user()->id,
                'status' => Order::OPEN,
                'uuid' => Str::uuid()
            ]);
            return response()->json(['status' => true, 'order' => $order], 201);
         } catch (\Throwable $e) {
             \Log::info($e);
             return response()->json(['status' => false, 'message' => 'Invalid request', 'errors' => $e->getMessage()], 400);
         }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($uuid){
        try {
            $order = Order::with('line_items','line_items.product')->whereUuid($uuid)->first();
            return response()->json(['status' => true, 'order' => $order], 201);
         } catch (\Throwable $e) {
             \Log::info($e);
             return response()->json(['status' => false, 'message' => 'Invalid request', 'errors' => $e->getMessage()], 400);
         }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order){
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid){
        try {
            $order = Order::whereUuid($uuid)->first();
            $order->delete();
            return response()->json(['status' => true], 200);
         } catch (\Throwable $e) {
             \Log::info($e);
             return response()->json(['status' => false, 'message' => 'Invalid request', 'errors' => $e->getMessage()], 400);
         }
    }
}
