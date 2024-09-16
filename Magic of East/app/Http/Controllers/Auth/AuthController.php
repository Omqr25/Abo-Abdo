<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['only' => 'logout']);
    }

    public function register(RegisterRequest $request)
    {
        $data=$request->validated();
        $user=User::create([
            'name'=>$data['name'],
            'phone'=>$data['phone'],
            'password'=>Hash::make($request['password']),
            'address'=>$data['address'],
        ]);
        return $user;
    }

    public function login(LoginRequest $request)
    {
        $data=$request->validated();
        $user = User::where('phone', $data['phone'])->first();
        if (!is_null($user)) {
            if (!Auth::attempt(['phone' => $data['phone'], 'password' => $data['password']])) {
                $message = 'User phone & password do not match with our records.';
                return $message;
            } else {
                    $user['access_token'] = $user->createToken("token")->plainTextToken;
                    return $user;
            }
        } else {
            $message = 'User not found.';
            return $message;
        }
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return new ApiResponse(null, 'Successfully logged out', 200);
    }
}
