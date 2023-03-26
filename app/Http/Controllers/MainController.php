<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Contracts\Providers\Auth;
// use Illuminate\Contracts\Validation\Validator;

class MainController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api')->except('login');
    // }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = User::create(array_merge(
            $validator->validated(),
            [
                'password' => bcrypt($request->password),
            ]
        ));
        return response()->json([
            'message' => 'user created successfully',
            'user' => $user
        ]);
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = User::where('id', $request->id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        if ($user->save())
            return response()->json([
                'message' => 'user updated successfully',
                'user' => $user
            ]);
    }
    public function login(Request $request)
    {
        // $request->password = md5($request->password);
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:50',
            'password' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        if (!$token = auth('api')->attempt($validator->validated(), true)) {
            return response()->json([
                'error' => 'Unauthorized user',
            ]);
        }
        return $this->respondWithToken($token);
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
    public function profile()
    {
        return response()->json(auth()->user());
    }
    public function logout()
    {
        auth()->logout();
        return response()->json([
            'meassage' => 'User logout successfully',
        ]);
    }
}
