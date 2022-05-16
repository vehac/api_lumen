<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Pre-Middleware Action
        try {
            $code = 403;
            $res = [
                'code' => $code, 
                'status' => 'ERROR',
                'result' => NULL,
                'msg' => ''
            ];
            $jwtHeader = $request->header('Authorization');
            if(!$jwtHeader) {
                $res['msg'] = 'JWT Token requerido.';
                return response()->json($res, $code);
            }
            $jwt = explode('Bearer ', $jwtHeader);
            if(!isset($jwt[1])) {
                $res['msg'] = 'JWT Token no existe.';
                return response()->json($res, $code);
            }
            $jwt_trim = preg_replace('/\s+/',' ', trim($jwt[1]));

            $decoded = $this->validateToken($jwt_trim);
            if($decoded->sub != config('auth_jwt.jwt_id')) {
                $res['msg'] = 'JWT Token inválido.';
                return response()->json($res, $code);
            }
            $request->decoded = $decoded;
            $response = $next($request);
        }catch(\Exception $e) {
             $res = [
                'code' => 403, 
                'status' => 'ERROR',
                'result' => NULL,
                'msg' => $e->getMessage()
            ];
            return response()->json($res, 403);
        }
        // Post-Middleware Action
        return $response;
    }
    
    private function validateToken($token) {
        try {
            return JWT::decode(trim($token), new Key(config('auth_jwt.jwt_secret'), 'HS256'));
        }catch(\Exception $e) {
            throw new \Exception($e->getMessage(), 403);
        }
    }
}
