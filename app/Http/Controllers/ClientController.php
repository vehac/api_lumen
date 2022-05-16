<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller {
    
    /**
     *  @OA\Get(
     *      path="/api/v1/clients",
     *      summary="Endpoint para listar los clientes.",
     *      tags={"Client"},
     *      description="Retorna los datos de todos los clientes.",
     *      operationId="getClients",
     *      parameters={},
     *      @OA\Response(
     *          response=200,
     *          description="SUCCESS",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/client_model"),
     *              example=
     *              {
     *                  "code": 200,
     *                  "status": "SUCCESS",
     *                  "result": {
     *                      {
     *                          "id": 1,
     *                          "name": "Luis",
     *                          "lastname": "Salinas Vela",
     *                          "image": "/upload/626f2e5062f16_foto_test.png",
     *                          "gender": "M",
     *                          "description": "Descripción de Luis",
     *                          "phone": "948656565",
     *                          "country": "Perú",
     *                          "address": "Miraflores 1247",
     *                          "birth_date": "1990-11-11",
     *                          "created_at": "2022-05-02 01:05:20",
     *                          "updated_at": null
     *                      }
     *                  },
     *                  "msg": "Listado realizado con éxito."
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        try {
            $code = 200;
            $client = Client::all();
            $response = [
                'code' => $code, 
                'status' => 'SUCCESS', 
                'result' => $client, 
                'msg' => 'Listado realizado con éxito.'
            ];
        }catch(\Exception $ex) {
            $code = 400;
            $response = [
                'code' => $code, 
                'status' => 'ERROR',
                'result' => NULL,
                'msg' => $ex->getMessage()
            ];
        }
        return response()->json($response, $code);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/clients",
     *      tags={"Client"},
     *      operationId="newClient",
     *      summary="Endpoint para registrar cliente.",
     *      description="Permite crear un cliente",
     *      security={{"bearerAuth": {}}},
     *      @OA\RequestBody(
     *          description="Objeto cliente que se va a crear",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      description="Nombre de cliente",
     *                      property="name", type="string", example="Luis"),
     *                  @OA\Property(
     *                      description="Apellidos de cliente",
     *                      property="lastname", type="string", example="Ramos Vela"),
     *                  @OA\Property(
     *                      description="Foto de cliente",
     *                      property="image", type="file"),
     *                  @OA\Property(
     *                      description="Género de cliente",
     *                      property="gender", type="char", example="M"),
     *                  @OA\Property(
     *                      description="Descripción de cliente",
     *                      property="description", type="string", example="Descripción de cliente"),
     *                  @OA\Property(
     *                      description="Celular de cliente",
     *                      property="phone", type="string", example="948656565"),
     *                  @OA\Property(
     *                      description="País de cliente",
     *                      property="country", type="string", example="Perú"),
     *                  @OA\Property(
     *                      description="Dirección de cliente",
     *                      property="address", type="string", example="Miraflores 1247"),
     *                  @OA\Property(
     *                      description="Fecha nacimiento de cliente",
     *                      property="birth_date", type="date", example="1990-11-11"),
     *                  required={"name", "lastname", "birth_date"}
     *              )
     *          )
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="SUCCESS",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example=
     *              {
     *                  "code": 200,
     *                  "status": "SUCCESS",
     *                  "result": null,
     *                  "msg": "Cliente creado con éxito."
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
     *                  "msg": "JWT Token requerido."
     *              }
     *          )
     *      )
     * )
     * 
     * Create a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        try {
            $this->validate($request, [
                'name' => 'required|string',
                'lastname' => 'required|string',
                'birth_date' => 'required|date|date_format:Y-m-d',
            ]);

            if(!$request->name) {
                throw new \Exception('Datos no válidos.');
            }
            if(!$request->lastname) {
                throw new \Exception('Datos no válidos.');
            }
            $code = 200;
            $client = new Client;
        
            $nameImagenNew = 'default.png';
            $directoryEnd = './upload/';
            if($request->hasFile('image')) {
                $nameImageOrigin = $request->file('image')->getClientOriginalName();
                $nameImagenNew = uniqid() . "_" . $nameImageOrigin;
                
                $request->file('image')->move($directoryEnd, $nameImagenNew);
            }

            $client->name = $request->name;
            $client->lastname = $request->lastname;
            $client->image = ltrim($directoryEnd, '.') . $nameImagenNew;
            $client->gender = $request->gender;
            $client->description = $request->description;
            $client->phone = $request->phone;
            $client->country = $request->country;
            $client->address = $request->address;
            $client->birth_date = $request->birth_date ? $request->birth_date : NULL ;
            $client->created_at = date('Y-m-d H:i:s');

            $client->save();
            
            $response = [
                'code' => $code, 
                'status' => 'SUCCESS',
                'result' => NULL,
                'msg' => 'Cliente creado con éxito.'
            ];
        }catch (\Exception $ex) {
            $code = 400;
            $response = [
                'code' => $code, 
                'status' => 'ERROR',
                'result' => NULL,
                'msg' => $ex->getMessage()
            ];
        }
        return response()->json($response, $code);
    }

    /**
     *  @OA\Get(
     *      path="/api/v1/clients/{clientId}",
     *      tags={"Client"},
     *      summary="Endpoint para listar un cliente.",
     *      description="Retorna los datos de un cliente de acuerdo a su id.",
     *      operationId="getClient",
     *      @OA\Parameter(
     *          name="clientId",
     *          in="path",
     *          description="ID cliente",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int32"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="SUCCESS",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/client_model"),
     *              example=
     *              {
     *                  "code": 200,
     *                  "status": "SUCCESS",
     *                  "result": {
     *                      "id": 1,
     *                      "name": "Luis",
     *                      "lastname": "Salinas Vela",
     *                      "image": "/upload/626f2e5062f16_foto_test.png",
     *                      "gender": "M",
     *                      "description": "Descripción de Luis",
     *                      "phone": "948656565",
     *                      "country": "Perú",
     *                      "address": "Miraflores 1247",
     *                      "birth_date": "1990-11-11",
     *                      "created_at": "2022-05-02 01:05:20",
     *                      "updated_at": null
     *                  },
     *                  "msg": "Cliente retornado con éxito."
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
     * Display the specified resource.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        try {
            $code = 200;
            $client = new Client;
            
            $dataClient = $client->find($id);
            if($dataClient) {
                $response = [
                    'code' => $code, 
                    'status' => 'SUCCESS',
                    'result' => $dataClient,
                    'msg' => 'Cliente retornado con éxito.'
                ];
            }else {
                throw new \Exception('Cliente no existe.');
            } 
        }catch(\Exception $ex) {
            $code = 400;
            $response = [
                'code' => $code, 
                'status' => 'ERROR',
                'result' => NULL,
                'msg' => $ex->getMessage()
            ];
        }
        return response()->json($response, $code);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/clients/{clientId}",
     *      tags={"Client"},
     *      operationId="updateClient",
     *      summary="Endpoint para actualizar cliente.",
     *      description="Permite actualizar un cliente",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="clientId",
     *          in="path",
     *          description="ID cliente",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int32"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          description="Objeto cliente que se va a actualizar",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      description="Nombre de cliente",
     *                      property="name", type="string"),
     *                  @OA\Property(
     *                      description="Apellidos de cliente",
     *                      property="lastname", type="string"),
     *                  @OA\Property(
     *                      description="Foto de cliente",
     *                      property="image", type="file"),
     *                  @OA\Property(
     *                      description="Género de cliente",
     *                      property="gender", type="char"),
     *                  @OA\Property(
     *                      description="Descripción de cliente",
     *                      property="description", type="string"),
     *                  @OA\Property(
     *                      description="Celular de cliente",
     *                      property="phone", type="string"),
     *                  @OA\Property(
     *                      description="País de cliente",
     *                      property="country", type="string"),
     *                  @OA\Property(
     *                      description="Dirección de cliente",
     *                      property="address", type="string"),
     *                  @OA\Property(
     *                      description="Fecha nacimiento de cliente",
     *                      property="birth_date", type="date"),
     *                  required={"name"}
     *              )
     *          )
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="SUCCESS",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example=
     *              {
     *                  "code": 200,
     *                  "status": "SUCCESS",
     *                  "result": null,
     *                  "msg": "Cliente actualizado con éxito."
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
     *                  "msg": "JWT Token requerido."
     *              }
     *          )
     *      )
     * )
     * 
     * Update the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        try {
            $this->validate($request, [
                'name' => 'required|string',
                'lastname' => 'string',
                'birth_date' => 'date|date_format:Y-m-d',
            ]);
            
            if(!isset($id) || !is_numeric($id)) {
                throw new \Exception('Id no válido.');
            }
            $client_id = (int) $id;
            if($client_id <= 0) {
                throw new \Exception('Id no válido.');
            }
            
            $code = 200;
            $client = Client::find($id);
            if($client) {
                $directoryEnd = './upload/';
                if($request->hasFile('image')) {
                    $image = base_path('public').$client->image;
                    if(file_exists($image) && is_file($image) && '/upload/default.png' != $client->image) {
                        unlink($image);
                    }
                    $nameImageOrigin = $request->file('image')->getClientOriginalName();
                    $nameImagenNew = uniqid() . "_" . $nameImageOrigin;

                    $request->file('image')->move($directoryEnd, $nameImagenNew);
                    $client->image = ltrim($directoryEnd, '.') . $nameImagenNew;
                }
                if($request->input('name')) {
                    $client->name = $request->input('name');
                }
                if($request->input('lastname')) {
                    $client->lastname = $request->input('lastname');
                }
                if($request->input('gender')) {
                    $client->gender = $request->input('gender');
                }
                if($request->input('description')) {
                    $client->description = $request->input('description');
                }
                if($request->input('phone')) {
                    $client->phone = $request->input('phone');
                }
                if($request->input('country')) {
                    $client->country = $request->input('country');
                }
                if($request->input('address')) {
                    $client->address = $request->input('address');
                }
                if($request->input('birth_date') && $request->input('birth_date') != "") {
                    $client->birth_date = $request->input('birth_date');
                }
                
                $client->updated_at = date('Y-m-d H:i:s');

                $client->save();

                $response = [
                    'code' => $code, 
                    'status' => 'SUCCESS',
                    'result' => NULL,
                    'msg' => 'Cliente actualizado con éxito.'
                ];
            }else {
                throw new \Exception('Cliente no existe.');
            }
        }catch (\Exception $ex) {
            $code = 400;
            $response = [
                'code' => $code, 
                'status' => 'ERROR',
                'result' => NULL,
                'msg' => $ex->getMessage()
            ];
        }
        return response()->json($response, $code);
    }


    /**
     *  @OA\Delete(
     *      path="/api/v1/clients/{clientId}",
     *      tags={"Client"},
     *      summary="Endpoint para eliminar un cliente.",
     *      description="Permite eliminar un cliente de acuerdo a su id.",
     *      operationId="deleteClient",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="clientId",
     *          in="path",
     *          description="ID cliente",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int32"
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
     *                  "result": null,
     *                  "msg": "Eliminación realizada con éxito."
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
     *                  "msg": "JWT Token requerido."
     *              }
     *          )
     *      )
     *  )
     * 
     * Delete the specified resource.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id) {
        try {
            if(!isset($id) || !is_numeric($id)) {
                throw new \Exception('Id no válido.');
            }
            $client_id = (int) $id;
            if($client_id <= 0) {
                throw new \Exception('Id no válido.');
            }
            $code = 200;
            $client = Client::find($id);
            
            if($client) {
                $image = base_path('public').$client->image;
                if(file_exists($image) && is_file($image) && '/upload/default.png' != $client->image) {
                    unlink($image);
                }
                $client->delete();
                $response = [
                    'code' => $code, 
                    'status' => 'SUCCESS',
                    'result' => NULL,
                    'msg' => 'Eliminación realizada con éxito.'
                ];
            }else {
                throw new \Exception('Cliente no existe.');
            } 
        }catch(\Exception $ex) {
            $code = 400;
            $response = [
                'code' => $code, 
                'status' => 'ERROR',
                'result' => NULL,
                'msg' => $ex->getMessage()
            ];
        }
        return response()->json($response, $code);
    }
}
