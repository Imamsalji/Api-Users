<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Token;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends Controller
{
    private $key = 'Imamsalji123890'; // Ubah sesuai kebutuhan

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $payload = [
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + 3600
        ];
        $token = JWT::encode($payload, $this->key, 'HS256');
        // var_dump($user);
        // die;
        Token::create([
            'user_id' => $user->id,
            'token' => $token
        ]);


        return response()->json(['token' => $token], 200);
    }

    public function logout(Request $request)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['message' => 'Token not provided'], 400);
        }

        Token::where('token', str_replace('Bearer ', '', $token))->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
