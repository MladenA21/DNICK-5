<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Validator;

class AuthController extends Controller
{
    public function logout()
    {
        Auth::user()->tokens()->delete();

        return response()->json([], 200)
        ->withCookie(Cookie::forget('userAuth'));
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::find(Auth::user()->id);
            $success['token'] =  $user->createToken('userAuth')->plainTextToken;
            $success['name'] =  $user->name;

            return response()->json($success, 200)
            ->withCookie(Cookie::make("userAuth", $success['token'], 262800));
        }

        return response()->json(['error' => 'Unauthorised'], 401);
    }
}