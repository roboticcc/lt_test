<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $v = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'name' => 'required|string|unique:users',
            'password' => 'required|min:3|confirmed',
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }
        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json(['status' => 'success'], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if ($token = $this->guard()->attempt($credentials)) {
            return response()->json(['status' => 'success', 'token' => $token], 200)->header('Authorization', $token);
        }
        return response()->json(['error' => 'Email or password are not correct'], 401);
    }

    public function logout(): JsonResponse
    {
        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out successfully.'
        ], 200);
    }

    public function user(Request $request): JsonResponse
    {
        $user = User::find(Auth::user()->id);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function refresh(): mixed
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'successs', 'token' => $token], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }

    private function guard(): Guard|StatefulGuard
    {
        return Auth::guard();
    }
}
