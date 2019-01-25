<?php

namespace App\Http\Controllers;

use App\Documento;
use App\Mensaje;
use App\Planilla;
use App\PlanillaMensaje;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class EnviarController extends Controller
{
    public function index(Request $request){

        $oficinas=\DB::select("SELECT u.id, o.name, u.name as nombre,u.last_name FROM oficinas o, users u WHERE u.oficina_id=o.id and u.id!=1 and u.id!=".Auth::user()->id);
        if($request->has('inicio')){
            $inicio=$request->inicio;
            $final=$request->final;
            $nombre=$request->nombre;
        }else{
            $inicio=Carbon::now()->firstOfMonth()->toDateString();
            $final=Carbon::now()->endOfMonth()->toDateString();
            $nombre="";
        }
        $imagens=Documento::where('user_id',Auth::user()->id)->where('fecha','>',$inicio)
            ->where('fecha','<',$final)->where('nombre','like','%'.$nombre.'%')->get();
        return view('secretario.enviar.index',compact('imagens','oficinas','inicio','final','nombre'));

    }
    public function store(Request $request){

        $rules = [
            "to_user_id" => "required",
            "mensaje" => "required",
            "asunto" => "required",
            "list" => "required",
        ];
        $messages = [
            "to_user_id.required" => "El destinatario es requerido",
            "mensaje.required" => "Debe de escribir un mensaje",
            "asunto.required" => "El asunto debe de ser escrito",
            "list.required" => "cargue alguna imagen",
        ];

        $bool = Validator::make($request->all(), $rules, $messages);
        if($bool->fails()){
            return redirect()->back()->withErrors($bool->errors());
        }

        foreach($request->to_user_id as $us){
            $mensaje=new Mensaje();
            $mensaje->to_user_id=$us;
            $mensaje->mensaje=strtoupper($request->mensaje);
            $mensaje->asunto=strtoupper($request->asunto);
            $mensaje->from_user_id=Auth::user()->id;
            $mensaje->estado="Enviado";
            $mensaje->save();
            $split=explode(',',$request->get('list'));
            foreach($split as $s){
                \DB::select('insert into planilla_mensajes (mensaje_id,documento_id) VALUES (?,?)',[$mensaje->id,$s]);
            }
        }

        Session::flash('save','El archivo fue enviado corrextamente');
        return redirect('mensajes');

    }
    public function mensajes(){

        $men=Auth::user()->MEEt();
        foreach($men as $m){
            $edit=Mensaje::find($m->id);
            $edit->estado="Recivido";
            $edit->save();
        }
        $mensajes=Auth::user()->MALL();
        return view("secretario.enviar.mensajes",compact('mensajes'));
    }
    public function leer($id){
        $mensaje=Mensaje::find($id);
        if($mensaje!=null){
            if(Auth::user()->id==$mensaje->to_user_id){
                $mensaje->estado="Visto";
                $mensaje->save();
                $mensajes=\DB::select('SELECT m.*,p.image,p.id as pid FROM mensajes m, planilla_mensajes pm, documentos p WHERE p.id=pm.documento_id and pm.mensaje_id=m.id and m.id='.$id);
                $user=Auth::user()->UserNameFromMesseger($mensaje->from_user_id);
                return view('secretario.enviar.leer',compact('user','mensaje','mensajes'));
            }
            else{
                Session::flash("error","El mensaje no esta disponible");
                return redirect('mensajes');
            }
        }else{
            Session::flash("error","El mensaje no esta disponible");
            return redirect('mensajes');
        }
    }
    protected function downloadFile($src){

        if(file_exists($src)){
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $content_type = finfo_file($finfo, $src);
            finfo_close($finfo);
            $file_name = basename($src).PHP_EOL;
            $size = filesize($src);
            header("Content-Type: $content_type");
            header("Content-Disposition: attachment; filename=$file_name");
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: $size");
            readfile($src);
            return true;
        } else{
            return false;
        }
    }
    public function descargar($id){
        $pla=Documento::find($id);

        if(!$this->downloadFile(public_path().$pla->image)){
            return redirect()->back();
        }
    }
    public function enviados(){
        $mensajes=Auth::user()->MEEf();
        return view("secretario.enviar.enviados",compact('mensajes'));
    }
    public function leerenviados($id){
        $mensaje=Mensaje::find($id);
        $user=Auth::user()->UserNameToMesseger($mensaje->to_user_id);
        $mensajes=\DB::select('SELECT m.*,p.image,p.id as pid FROM mensajes m, planilla_mensajes pm, documentos p WHERE p.id=pm.documento_id and pm.mensaje_id=m.id and m.id=?',[$id]);
        return view('secretario.enviar.leerenviado',compact('user','mensaje','mensajes'));
    }
}
