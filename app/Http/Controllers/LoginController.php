<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
 
class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);
            if (Auth::attempt($credentials)) {
                return response()->json(['status' => true, 'user' => auth()->user()]);
            }
            return response()->json(['status' => false, 'message' => 'invalid username or password'], 500);
        } catch (\Throwable $e) {
            \Log::info($e);
            return response()->json(['status' => false, 'message' => 'Invalid request', 'errors' => $e->getMessage()], 500);
        }
    }
}