<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 200,
                'error' => false,
                'data' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]);
        } catch (Error $err) {
            return response()->json([
                'status' => 200,
                'error' => true,
                'message' => 'Wah ada error nih, gimana? ' + $err->getMessage()
            ]);
        }
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => 401,
                'error' => true,
                'message' => 'Unauthorized'
            ]);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 200,
            'error' => false,
            'message' => 'Login success',
            'access_token' => $token,
            'token_type' => 'Bearer',

        ]);
    }

    public function detail(Request $request)
    {
        return response()->json([
            'status' => 200,
            'error' => false,
            'data' => $request->user()
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'status' => 200,
            'error' => false,
            'message' => 'logout success'
        ]);
    }

    public function unAuthenticated()
    {
        return response()->json([
            'status' => 300,
            'error' => true,
            'message' => "Wah ada error nih, Login dulu lah",
        ]);
    }
}
