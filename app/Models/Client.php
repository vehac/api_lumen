<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="client_model",
 *      description="Client Model",
 *      type="object",
 *      title="Client"
 * )
 */
class Client extends Model {
    protected $table = "clients";
    protected $primaryKey = 'id';
    //Permite desactivar el seteo de fechas a los campos created_at y updated_at 
    //en la tabla de forma automática
    public $timestamps = false;
    
    /**
     * Id de cliente
     *
     * @var int
     * @OA\Property(property="id", format="int32", example=1)
     */
    protected $id;
    
    /**
     * Nombre de cliente
     *
     * @var string
     * @OA\Property(property="name", example="Luis")
     */
    protected $name;
    
    /**
     * Apellidos de cliente
     *
     * @var string
     * @OA\Property(property="lastname", example="Ramos Vela")
     */
    protected $lastname;
    
    /**
     * Foto de cliente
     *
     * @var string
     * @OA\Property(property="image", example="/upload/626f2e5062f16_foto_test.png")
     */
    protected $image;
    
    /**
     * Género de cliente
     *
     * @var string
     * @OA\Property(property="gender", format="char", example="M")
     */
    protected $gender;
    
    /**
     * Descripción de cliente
     *
     * @var string
     * @OA\Property(property="description", example="Descripción de Cliente")
     */
    protected $description;
    
    /**
     * Celular de cliente
     *
     * @var string
     * @OA\Property(property="phone", example="948656565")
     */
    protected $phone;
    
    /**
     * País de cliente
     *
     * @var string
     * @OA\Property(property="country", example="Chile")
     */
    protected $country;
    
    /**
     * Dirección de cliente
     *
     * @var string
     * @OA\Property(property="address", example="Miraflores 1247")
     */
    protected $address;
    
    /**
     * Fecha nacimiento de cliente
     *
     * @var string
     * @OA\Property(property="birth_date", format="date", example="1990-11-11")
     */
    protected $birth_date;
    
    /**
     * Fecha creación de cliente
     *
     * @var string
     * @OA\Property(property="created_at", format="datetime", example="2022-05-02 01:05:20")
     */
    protected $created_at;
    
    /**
     * Fecha actualización de cliente
     *
     * @var string|null
     * @OA\Property(property="updated_at", format="datetime", example="2022-05-02 05:08:59")
     */
    protected $updated_at;
}
