<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        try {
           return response()->json(['status' => true, 'products' => Product::paginate(15)], 200);
        } catch (\Throwable $e) {
            \Log::info($e);
            return response()->json(['status' => false, 'message' => 'Invalid request', 'errors' => $e->getMessage()], 500);
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
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string','max:500'],
                'image_url' => ['required', 'url'],
                'amount' => ['required', 'numeric'],
            ]);

            if($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Invalid request', 'errors' => $validator->errors()], 500);
            }
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'image_url' => $request->image_url,
                'amount' =>  $request->amount,
            ]);
            return response()->json(['status' => true, 'product' => $product], 201);

         } catch (\Throwable $e) {
             \Log::info($e);
             return response()->json(['status' => false, 'message' => 'Invalid request', 'errors' => $e->getMessage()], 400);
         }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product){
        try {
            
            return response()->json(['status' => true, 'product' => $product], 200);
         } catch (\Throwable $e) {
             \Log::info($e);
             return response()->json(['status' => false, 'message' => 'Invalid request', 'errors' => $e->getMessage()], 400);
         }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product){
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string','max:500'],
                'image_url' => ['required', 'url'],
                'amount' => ['required', 'numeric'],
            ]);

            if($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Invalid request', 'errors' => $validator->errors()], 500);
            }
            $product->update($request->only(['name', 'description', 'image_url', 'amount']));
            return response()->json(['status' => true, 'product' => $product], 200);
         } catch (\Throwable $e) {
             \Log::info($e);
             return response()->json(['status' => false, 'message' => 'Invalid request', 'errors' => $e->getMessage()], 400);
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product){
        try {
            $product->delete();
            return response()->json(['status' => true], 200);
         } catch (\Throwable $e) {
             \Log::info($e);
             return response()->json(['status' => false, 'message' => 'Invalid request', 'errors' => $e->getMessage()], 400);
         }
    }
}
