<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanillaMensaje extends Model
{
    protected $table="planilla_mensajes";
    protected $fillable=[
        'mensaje_id','planilla_id'
    ];
}
