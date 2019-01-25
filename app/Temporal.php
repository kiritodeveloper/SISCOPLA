<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temporal extends Model
{
    protected $table="temporals";
    protected $fillable=[
        'image','minimagen','bytes','user_id','tipo'
    ];
}
