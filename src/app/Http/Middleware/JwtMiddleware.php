<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\Token;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware
{
    private $key = 'Imamsalji123890';

    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = str_replace('Bearer ', '', $token);
        $storedToken = Token::where('token', $token)->first();

        if (!$storedToken) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        try {
            $decoded = JWT::decode($token, new Key($this->key, 'HS256'));
            $request->attributes->set('user_id', $decoded->sub);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        return $next($request);
    }
}
