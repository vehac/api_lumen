<?php
return [
    'jwt_secret' => env('JWT_SECRET_KEY', '12345jhytgruiopmnbvcxzasdmncdes67890'),
    'jwt_user' => env('JWT_USER', 'user_api'),
    'jwt_pass' => env('JWT_PASSWORD', 'pass7fgiy7udeg7word'),
    'jwt_exp' => env('JWT_EXP', 86400),  //24 horas activo
    'jwt_id' => env('JWT_ID', 9853777),
];