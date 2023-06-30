<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

    class UserController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index() {
            try {
                return response()->json(['status' => true, 'users' => User::paginate(15)], 200);
            } catch (\Throwable $e) {
                \Log::info($e);
                return response()->json(['status' => false, 'message' => 'Invalid request', 'errors' => $e->getMessage()], 500);
            }
        }
        /**
         * create new user
         *
         * @param Request $request
         * @return \Illuminate\Http\JsonResponse
         */
        public function store(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:4', 'confirmed'],
            ]);
            if($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Invalid request', 'errors' => $validator->errors()], 500);
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            return response()->json(['status' => true, 'user' => $user], 201);
        }
        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \App\Models\User  $user
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, User $user){
            try {
                $validator = Validator::make($request->all(), [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string','max:255'],
                    'password' => ['nullable', 'string', 'min:4', 'confirmed'],
                    'change_password' => ['required', 'boolean'],
                ]);

                if($validator->fails()) {
                    return response()->json(['status' => false, 'message' => 'Invalid request', 'errors' => $validator->errors()], 500);
                }
                $user->name = $request->name;
                if($request->change_password){
                    $user->password = Hash::make($request->password);
                }
                $user->save();
                return response()->json(['status' => true, 'user' => $user], 200);
            } catch (\Throwable $e) {
                \Log::info($e);
                return response()->json(['status' => false, 'message' => 'Invalid request', 'errors' => $e->getMessage()], 500);
            }
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  \App\Models\User  $user
         * @return \Illuminate\Http\Response
         */
        public function destroy(User $user){
            try {
                $user->delete();
                return response()->json(['status' => true], 200);
            } catch (\Throwable $e) {
                \Log::info($e);
                return response()->json(['status' => false, 'message' => 'Invalid request', 'errors' => $e->getMessage()], 500);
            }
        }
    }