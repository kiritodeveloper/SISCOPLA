<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planilla extends Model
{
    protected $table='planillas';

    protected $fillable=['image','observacion','shift','date','user_id','bytes','minimagen'];
}
