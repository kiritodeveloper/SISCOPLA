<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;
    protected $table='users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','ci','username', 'email', 'password', 'last_name','celular','oficina_id'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function unidad(){
        return $this->belongsTo(Oficina::class,'oficina_id');
    }
    public function MEEt(){
        $query=Mensaje::where('to_user_id',Auth::user()->id)->where('estado','Enviado')->get();
        return $query;
    }
    public function MEEf(){
        $query=Mensaje::where('from_user_id',Auth::user()->id)->orderby('created_at','des')->get();
        return $query;
    }
    public function MER(){
        $query=Mensaje::where('to_user_id',Auth::user()->id)->where('estado','Recivido')->get();
        return $query;
    }
    public function MALL(){
        $query=Mensaje::where('to_user_id',Auth::user()->id)->orderby('created_at','des')->get();
        return $query;
    }

    public function UserNameFromMesseger($id){
        $user=\DB::select('SELECT o.name, u.name as nombre FROM oficinas o, users u WHERE u.oficina_id=o.id and u.id='.$id);

        return $user[0];
    }
    public function UserNameToMesseger($id){
        $user=\DB::select('SELECT o.name, u.name as nombre FROM oficinas o, users u WHERE u.oficina_id=o.id and u.id='.$id);
        return $user[0];
    }
}
