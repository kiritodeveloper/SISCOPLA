<?php

namespace App\Http\Controllers;

use App\Documento;
use App\Planilla;
use App\Temporal;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class DocumentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documentos=Documento::where('user_id',Auth::user()->id);
        $temps=Temporal::where('user_id',Auth::user()->id)->where('tipo','documento')->get();

        $i=0;
        $res1=$res2=[];
        foreach ($temps as $temp) {
            $key=$temp->id;
            $url='/eliminararchivo/'.$temp->id;
            $res1[$i] = ''.$temp->image;
            $nombre = $this->generateRandomString();
            $ctime=Carbon::now()->toDateString();
            $nombre=base64_encode($nombre.$ctime);
            $token=csrf_token();
            $res2[$i]= ['caption' => $nombre.'.jpg', 'size' => 732762, 'width' => '120px', 'url' => $url, 'key' => $key,'extra'=>['_token'=>$token]];
            $i++;
        }

        return view('secretario.documento.index',compact('documentos','res1','res2'));
    }
private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
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
        $temps=Temporal::where('user_id',Auth::user()->id)->where('tipo','documento')->get();
        if(count($temps)>0){
            foreach ($temps as $temp) {
                $planilla=new Documento();
                $planilla->image=$temp->image;
                $planilla->minimagen=$temp->minimagen;
                $planilla->fecha=Carbon::now()->toDateTimeString();
                $planilla->nombre=strtoupper($request->get('nombre'));
                $planilla->user_id=Auth::user()->id;
                $planilla->bytes=$temp->bytes;
                $planilla->save();
                $t=Temporal::find($temp->id);
                $t->delete();
            }
            Session::flash("save","el guardado se realizo correctamente");
            return redirect()->back();
        }
        else{
            Session::flash('error','No se encontraron archivos cargados');
            Session::flash('noticie','El dato no se almaceno');
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
        //
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
        //
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
    public function revisar(){
        $users=$users=User::with('unidad')->where('id','!=','1')->get();
        
        return view('personal.index',compact('users'));
    }
    public function revisarxusuario(Request $request,$id){
        if(count($request->all())==0){
            $fecha=Carbon::now();
            $inicio=$fecha->firstOfMonth()->toDateString();
            $fin=$fecha->endOfMonth()->toDateString();
            $nombre="";
            $planillas=\DB::select('select * from planillas where user_id=? and date between ? and ?',[Crypt::decrypt($id),$inicio,$fin]);
            return view('personal.ver',compact('planillas','inicio','fin','id','nombre'));
        }else{
            $inicio=$request->inicio;
            $fin=$request->fin;
            $nombre=$request->nombre;
            $planillas=Documento::whereBetween('fecha',[$inicio,$fin])->where('nombre','like','%'.$nombre.'%')->where('user_id',Crypt::decrypt($id))->get();
            return view('personal.ver',compact('planillas','inicio','fin',"id",'nombre'));
        }
    }
    public function verdocumento(Request $request){
        if(count($request->all())==0){
            $fecha=Carbon::now();
            $inicio=$fecha->firstOfMonth()->toDateString();
            $fin=$fecha->endOfMonth()->toDateString();
            $nombre="";
            $planillas=\DB::select('select * from documentos where user_id=? and fecha between ? and ?',[Auth::user()->id,$inicio,$fin]);
            return view('secretario.documento.ver',compact('planillas','inicio','fin','nombre'));
        }else{
            $inicio=$request->inicio;
            $fin=$request->fin;
            $nombre=$request->nombre;
            $planillas=Documento::whereBetween('fecha',[$inicio,$fin])->where('nombre','like','%'.$nombre.'%')->where('user_id',Auth::user()->id)->get();
            return view('secretario.documento.ver',compact('planillas','inicio','fin','nombre'));
        }
    }
    public function eliminarimagenes(){
        $temps=Temporal::where('user_id',Auth::user()->id)->get();
        foreach($temps as $t){
            $t->delete();
        }
        Session::flash("noticie","Las Imagenes Temporales se eliminarion correctamente");
        return redirect()->back();
    }
}
