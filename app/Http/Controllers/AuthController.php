<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{   
    public function signin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();

        return response()->json([
            'email' => $user->email,
            'token' => $token,
            'username' => $user->username
        ], 201);
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user.username' => 'required|string',
            'user.email' => 'required|string',
            'user.encrypted_password' => 'required|string',
            'user.phone' => 'required|string',
            'user.address' => 'required|string',
            'user.city' => 'required|string',
            'user.country' => 'required|string',
            'user.name' => 'required|string',
            'user.postcode' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create([
                'username' => $request->user["username"],
                'email' => $request->user["email"],
                'password' => bcrypt($request->user["encrypted_password"]),
                'phone' => $request->user["phone"],
                'address' => $request->user["address"],
                'city' => $request->user["city"],
                'country' => $request->user["country"],
                'name' => $request->user["name"],
                'postcode' => $request->user["postcode"],
            ]
        );

        $token = Auth::login($user);

        return response()->json([
            'email' => $user->email,
            'token' => $token,
            'username' => $user->username
        ], 201);
    }
}
