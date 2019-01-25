<?php

namespace App\Http\Controllers;

use App\Oficina;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UnidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unidads=Oficina::where('type','Unidad Mayor')->get();
        $unidad_mayors=Oficina::where('type','Unidad Mayor')->orwhere('type','Unidad Dependiente')->get();
        return view('administrador.unidad.index',compact('unidads','unidad_mayors'));
    }
    /**
     *
     */
    public function dependientes($id){
        $unidads=Oficina::where('oficina_id',$id)->where('type','Unidad Dependiente')->get();
        $unidad_mayors=Oficina::where('type','Unidad Mayor')->get();
        return view('administrador.unidad.index',compact('unidads','unidad_mayors'));
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
        try{
            $rules = [
                "name" => "required",
            ];
            $messages = [
                "name.required" => "Nombre de la Oficina es Requerido",
            ];

            $bool = Validator::make($request->all(), $rules, $messages);
            if($bool->fails()){
                return redirect()->back()->withErrors($bool->errors());
            }
            $val=Oficina::where('name',$request->name)->get();
            if(count($val)>0){
                Session::flash('error',"El nombre de unidad ya existe");
                return redirect()->back();
            }
            if($request->get('type')=="Unidad Mayor"){
                $unidad=new Oficina($request->all());
                $unidad->name=strtoupper($request->name);
                $unidad->oficina_id=0;
                $unidad->save();
                Session::flash('save','La Unidad ha sido almacenada correctamente');
                return redirect()->back();
            }else{
                $unidad=new Oficina($request->all());
                $unidad->name=strtoupper($request->name);
                $unidad->save();
                Session::flash('save','La Unidad ha sido almacenada correctamente');
                return redirect()->back();
            }
        }catch(Exception $e){
                Session::flash('error',$e->getMessage());
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
        $unidad=Oficina::find($id);
        $unidad_mayors=Oficina::where('type','Unidad Mayor')->get();
        return view('administrador.unidad.edit',compact('unidad','unidad_mayors'));
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
        try{
            $unidad=Oficina::find($id);
            $unidad->fill($request->all());
            $unidad->name=strtoupper($request->name);
            if($request->get('type')=="Unidad Mayor"){
                $unidad->oficina_id=0;
                $unidad->save();
                Session::flash('edit','La Unidad ha sido editada correctamente');
                return redirect()->route('unidad.index');
            }else{
                $unidad->save();
                Session::flash('edit','La Unidad ha sido editada correctamente');
                return redirect()->route('unidad.index');
            }
        }catch (\Exception $e){
            Session::flash('error','Ha ocurrido un error al tratar de editar la unidad');
            return redirect()->route('unidad.index');
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
        $id=Input::get('id');
        $dependientes=Oficina::where('oficina_id',$id)->get();
        $user=User::where('oficina_id',$id)->get();
        if(count($dependientes)==0 && count($user)==0){
            $fa=Oficina::find($id);
            $fa->delete();
            Session::flash('delete','La oficina fue eliminada correctamete');
            return "0";
        }
        Session::flash('error','Ha ocurrido un error al tratar de eliminar la facultad, puede que tenga carreras,usuarios dependientes de el');
        return "1";
    }
}
