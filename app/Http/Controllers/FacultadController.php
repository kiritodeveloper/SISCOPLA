<?php

namespace App\Http\Controllers;

use App\Oficina;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FacultadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unidads=Oficina::where('type','Facultad')->get();
        $unidad_mayors=Oficina::where('type','Facultad')->get();
        return view('administrador.facultad.index',compact('unidads','unidad_mayors'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function carreras($id){
        $unidads=Oficina::where('oficina_id',$id)->where('type','Carrera')->get();
        $unidad_mayors=Oficina::where('type','Facultad')->get();
        return view('administrador.facultad.index',compact('unidads','unidad_mayors'));
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
        if($request->get('type')=="Facultad"){
            $unidad=new Oficina($request->all());
            $unidad->name=strtoupper($request->name);
            $unidad->oficina_id=0;
            $unidad->save();
            Session::flash('save','La Facultad ha sido almacenada correctamente');
            return redirect()->back();
        }else{
            $unidad=new Oficina($request->all());
            $unidad->name=strtoupper($request->name);
            $unidad->save();
            Session::flash('save','La Carrera ha sido almacenada correctamente');
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
        $facultad=Oficina::find($id);
        $unidad_mayors=Oficina::where('type','Facultad')->get();
        return view('administrador.facultad.edit',compact('facultad','unidad_mayors'));
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
            if($request->get('type')=="Facultad"){
                $unidad->oficina_id=0;
                $unidad->save();
                Session::flash('edit','La facultad ha sido editada correctamente');
                return redirect()->route('facultad.index');
            }else{
                $unidad->save();
                Session::flash('edit','La Carrera ha sido editada correctamente');
                return redirect()->route('facultad.index');
            }
        }catch (\Exception $e){
            Session::flash('error','Ha ocurrido un error al tratar de editar la unidad');
            return redirect()->route('facultad.index');
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
