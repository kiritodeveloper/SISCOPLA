<?php

namespace App\Http\Controllers;

use App\Documento;
use App\Mensaje;
use App\Oficina;
use App\Planilla;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::where('id','!=','1')->where('active',true)->get();
        $facultads=Oficina::where('type','Facultad')->get();
        $unidads=Oficina::where('type','Unidad Mayor')->get();
        return view('administrador.user.index',compact('users','facultads','unidads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=new User($request->all());
        try{
        $rules = [
            "name" => "required",
            "last_name" => "required",
            "ci"=>"required",
            "email"=>"required|email",
            "celular"=>"required",
            "password"=>"required",
        ];
        $messages = [
            "name.required" => "Nombre del Usuario es Requerido",
            "last_name.required" => "apellido del Usuario es Requerido",
            "ci.required" => "La cedua de identidad es requerido",
            "email.required" => "El correo electronico es requerido",
            "email.email" => "El correo electronico No es valido",
            "celular.required" => "El celular de Usuario es requerido",
            "password.required" => "La contrase&ntilde;a es requerido",
        ];
        $user->name=strtoupper($request->name);
        $user->last_name=strtoupper($request->last_name);
        $bool = Validator::make($request->all(), $rules, $messages);
        if($bool->fails()){
            return redirect()->back()->withErrors($bool->errors());
        }
            switch($request->get('type')){
                case "Unidad Mayor":
                    $user->oficina_id=$request->get("unidad_mayor");
                    break;
                case "Unidad Dependiente":
                    $user->oficina_id=$request->get("unidad_dependiente");
                    break;
                case "Facultad":
                    $user->oficina_id=$request->get("facultad");
                    break;
                case "Carrera":
                    $user->oficina_id=$request->get("carrera");
                    break;
            }
            $user->password=bcrypt($request->get('password'));
             $user->password_text=($request->get('password'));

            $email=$request->email;
            $newpassword=$request->password;
            $name=$request->username;
            $ci=$request->ci;
            $bool=User::where('ci',$ci)->get();
            if(count($bool)>0){
                Session::flash("noticie",'La Cedula de Identidad ya existe');
                return redirect()->back();
            }
            $bool=User::where('email',$email)->get();
            if(count($bool)>0){
                Session::flash("noticie",'El email ya existe');
                return redirect()->back();
            }
         /*   \Mail::send('administrador.user.message', compact('name','newpassword'), function($message) use ($email)
            {
                $message->from('uatf.edu.sicorre@gmail.com','UATF');
                $message->subject('Nueva Cuenta de Usuario');
                $message->to($email,'UATF');
            });
*/
            $user->save();
            Session::flash("save",'El Usuario se almaceno Correctamente');
            return redirect()->back();
        }catch (\Exception $e){
            Session::flash("error",'Algo salio mal intente de nuevo por favor');
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user=User::find($id);
        $launidad=Oficina::find($user->oficina_id);
        $facultads=Oficina::where('type','Facultad')->get();
        $unidads=Oficina::where('type','Unidad Mayor')->get();
        return view('administrador.user.edit',compact('user','facultads','unidads','launidad'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        try {
            $user=User::find($id);
            $user->fill($request->all());
            switch ($request->get('type')) {
                case "Unidad Mayor":
                    $user->oficina_id = $request->get("unidad_mayor");
                    break;
                case "Unidad Dependiente":
                    $user->oficina_id = $request->get("unidad_dependiente");
                    break;
                case "Facultad":
                    $user->oficina_id = $request->get("facultad");
                    break;
                case "Carrera":
                    $user->oficina_id = $request->get("carrera");
                    break;
            }
            $user->save();
            Session::flash("edit", 'El Usuario ah sido editado Correctamente');
            return redirect()->route('user.index');
        }catch (\Exception $e){
            Session::flash("error", 'Algo ha salido mal, intente de nuevo por favor');
            return redirect()->route('user.edit',$id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function eliminar(){
        try{
            $id=Input::get('id');
            $user=User::find($id);
            $user->active=false;
            $user->save();
            Session::flash('delete','El Usuario fue eliminado correctamente');
            return '0';
        }catch (\Exception $e){
            Session::flash('error','El Usuario no se puede eliminar. error 505');
            return '1';
        }

    }
    public function generate_username(){
        $nombre=Input::get('nombre');
        $nombre=explode(' ',$nombre);
        $ci=Input::get('ci');
        $apellido=Input::get('apellido');
        $apellido=explode(' ',$apellido);
        $generado=$nombre[0]."_".$apellido[0];

        $bool=true;
        $i=0;
        while($bool==true){
            $user=User::where('username',$generado)->get();
            if(count($user)==0){
                return $generado;
            }
            else{
                $generado=$generado.$ci[$i];
            }
        }
    }
    public function excel(){
        Excel::create('Lista', function($excel) {
            $excel->sheet('Usuarios', function($sheet) {
                $users = User::all();
                $sheet->fromArray($users);
            });
        })->export('xls');
    }
    public function eliminados(){
        $users=User::where('active',false)->get();
        return view('administrador.user.eliminados',compact('users'));
    }
    public function alta(){
        try{
            $id=Input::get('id');
            $user=User::find($id);
            $user->active=true;
            $user->save();
            Session::flash('noticie','El Usuario fue dado de alta correctamente correctamente');
            return '0';
        }catch (\Exception $e){
            Session::flash('error','El Usuario no se puede dar de alta. error 505');
            return '1';
        }

    }
}
