<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        
        // if (!$user || Hash::check($request->password, $user->password)) {
        //     abort(500);
        // }

        $token = $user->createToken($request->device_name)->plainTextToken;
        return response()->json([
            'id'=>$user->id,
            'name'=>$user->name,
            'phone'=>$user->phone,
            'email'=>$user->email,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json('تم تسجيل الخروج بنجاح.');
    }
}
