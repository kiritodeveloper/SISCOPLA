<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $table='mensajes';
    protected $fillable=['from_user_id','to_user_id','estado','mensaje','asunto'];


}
