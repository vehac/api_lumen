<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

/**
 *  @OA\Info(
 *      title="API Lumen",
 *      version="1.0",
 *      description="Documentar api en lumen con swagger"),
 *  @OA\Server(
 *      description="Host",
 *      url="http://localhost:8482",
 *  ),
 *  @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      type="http",
 *      name="Authorization",
 *      in="header",
 *      scheme="Bearer",
 *      bearerFormat="JWT"
 *  )
 */
class Controller extends BaseController
{
    //
}
