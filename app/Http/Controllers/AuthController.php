<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;

class AuthController extends Controller {
    
    /**
     *  @OA\Post(
     *      path="/api/v1/generate-token",
     *      tags={"Auth"},
     *      summary="Endpoint para generar token",
     *      description="Permite generar token para usarlo en los endpoints que necesitan autorización.",
     *      operationId="generateToken",
     *      @OA\RequestBody(
     *          description="Datos para generar token",
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  description="Usuario para generar token (JWT_USER - ubicado en el .env)",
     *                  property="user", type="string", example="JWT_USER"),
     *              @OA\Property(
     *                  description="Password para generar token (JWT_PASSWORD - ubicado en el .env)",
     *                  property="pass", type="string", example="JWT_PASSWORD")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="SUCCESS",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example=
     *              {
     *                  "code": 200,
     *                  "status": "SUCCESS",
     *                  "result": {
     *                      "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5ODUzNzc3IiwiaWF0IjoxNjUyNTg3MjE3LCJleHAiOjE2NTI2NzM2MTd9.snz3gScby-26QoUwsitQUApoDxqSzvHJrE4EyUYvqpc"
     *                  },
     *                  "msg": "Token generado."
     *              }
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="ERROR",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example=
     *              {
     *                  "code": 400,
     *                  "status": "ERROR",
     *                  "result": null,
     *                  "msg": "Mensaje de error."
     *              }
     *          )
     *      )
     *  )
     * 
     */
    public function generateToken(Request $request) {
        try {
            if(!isset($request->user)) {
                throw new \Exception('El campo user es requerido.', 400);
            }
            if(!isset($request->pass)) {
                throw new \Exception('El campo pass es requerido.', 400);
            }
            if($request->user == "" || $request->pass == "") {
                throw new \Exception('Los parámetros no puden ser vacios.', 400);
            }
            if($request->user != config('auth_jwt.jwt_user') || $request->pass != config('auth_jwt.jwt_pass')) {
                throw new \Exception('Parámetros inválidos.', 400);
            }
            $date = new \DateTime();
            $dataToken['sub']    = config('auth_jwt.jwt_id');
            $dataToken['iat']    = $date->getTimestamp();
            $dataToken['exp']    = $date->getTimestamp() + config('auth_jwt.jwt_exp');
            $token = JWT::encode($dataToken, config('auth_jwt.jwt_secret'), 'HS256');
            
            $code = 200;
            $response = [
                'code' => $code, 
                'status' => 'SUCCESS',
                'result' =>["token" => $token],
                'msg' => 'Token generado.'
            ];
        }catch (\Exception $e) {
            $code = 400;
            $response = [
                'code' => $code, 
                'status' => 'ERROR',
                'result' => NULL,
                'msg' => $e->getMessage()
            ];
        }
        return response()->json($response, $code);
    }
    
    /**
     *  @OA\Post(
     *      path="/api/v1/verify-token",
     *      tags={"Auth"},
     *      summary="Endpoint para verificar el token",
     *      description="Permite verificar si el token está activo.",
     *      operationId="verifyToken",
     *      parameters={},
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="SUCCESS",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example=
     *              {
     *                  "code": 200,
     *                  "status": "SUCCESS",
     *                  "result": {
     *                      "is_active": true
     *                  },
     *                  "msg": "Token activo."
     *              }
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="ERROR",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example=
     *              {
     *                  "code": 403,
     *                  "status": "ERROR",
     *                  "result": null,
     *                  "msg": "Expired token"
     *              }
     *          )
     *      )
     *  )
     * 
     */
    public function verifyToken(Request $request) {
        try {
            if(!isset($request->decoded->sub)) {
                throw new \Exception('Token a expirado.', 403);
            }
            $code = 200;
            $response = [
                'code' => $code, 
                'status' => 'SUCCESS',
                'result' => ["is_active" => true],
                'msg' => 'Token activo.'
            ];
        }catch (\Exception $e) {
            $code = 403;
            $response = [
                'code' => $code, 
                'status' => 'ERROR',
                'result' => NULL,
                'msg' => $e->getMessage()
            ];
        }
        return response()->json($response, $code);   
    }
}
