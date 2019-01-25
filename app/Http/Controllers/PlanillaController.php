<?php

namespace App\Http\Controllers;

use App\Planilla;
use App\Temporal;
use App\Documento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Imagick;
use Intervention\Image\Facades\Image;

class PlanillaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $planillas=Planilla::where('user_id',Auth::user()->id)->orderby('date','des')->get();

        $temps=Temporal::where('user_id',Auth::user()->id)->where('tipo','planilla')->get();
        $i=0;
        $res1=$res2=[];
        foreach ($temps as $temp) {
            $key=$temp->id;
            $url=\Illuminate\Support\Facades\Request::root().'/eliminararchivo/'.$temp->id;
            $res1[$i] = ''.$temp->image;
            $nombre = $this->generateRandomString();
            $ctime=Carbon::now()->toDateString();
            $nombre=base64_encode($nombre.$ctime);
            $token=csrf_token();
            $res2[$i]= ['caption' => $nombre.'.jpg', 'size' => 732762, 'width' => '120px', 'url' => $url, 'key' => $key,'extra'=>['_token'=>$token]];
            $i++;
        }

        return view('secretario.planilla.index',compact('planillas','res1','res2'));
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

        $temps=Temporal::where('user_id',Auth::user()->id)->where('tipo','planilla')->get();
        if(count($temps)>0){
            foreach ($temps as $temp) {
                $planilla=new Planilla();
                $planilla->image=$temp->image;
                $planilla->minimagen=$temp->minimagen;
                $planilla->date=Carbon::now()->toDateTimeString();
                $planilla->shift=$request->get('shift');
                $planilla->observacion=$request->get('observacion');
                $planilla->user_id=Auth::user()->id;
                $planilla->bytes=$temp->bytes;
                $planilla->save();
                $t=Temporal::find($temp->id);
                $t->delete();
            }
            Session::flash('save','El archivo fue guardado correctamente');
            return redirect()->route('planilla.index');
        }
        else{
            Session::flash('error','No se encontraron archivos cargados');
            Session::flash('noticie','El dato no se almaceno');
            return redirect()->route('planilla.index');
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
        dd($id);
    }

    public function verplanilla(Request $request){

        if(count($request->all())==0){
            $fecha=Carbon::now();
            $inicio=$fecha->firstOfMonth()->toDateString();
            $fin=$fecha->endOfMonth()->toDateString();
            $planillas=\DB::select('select * from planillas where user_id = ? and date between ? and ?',[Auth::user()->id,$inicio,$fin]);
            //Planilla::whereMonth('date',$fecha->month)->whereYear('date',$fecha->year)->where('user_id',Auth::user()->id)->get();
            return view('secretario.planilla.ver',compact('planillas','inicio','fin'));
        }else{
            $inicio=$request->inicio;
            $fin=$request->fin;
            $planillas=\DB::select('select * from planillas where user_id = ? and date between ? and ?',[Auth::user()->id,$inicio,$fin]);
            return view('secretario.planilla.ver',compact('planillas','inicio','fin'));
        }

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
    //para el scaneo
    public function submitimagen(Request $request){
        try{

        $type=$request->type;
        $file = base64_decode($request->imagen);
        $nombre = $this->generateRandomString();
        $ctime=Carbon::now()->toDateString();
        $nombre=base64_encode($nombre.$ctime);
        $year=Carbon::now()->year;
        $token=$request->get('_token');
        $name_month=Config::get('constants.months.'.Carbon::now()->month);
        //if tipo de documento
    
        if($type=="planilla"){
            $path=public_path().'/imagenes/'.$year.'/'.$name_month.'/'.$nombre;
            $pathmini=public_path().'/imagenes/miniatura/'.$year.'/'.$name_month.'/'.$nombre;
            if(!File::exists(public_path('imagenes/'.$year.'/'.$name_month))){
                File::makeDirectory(public_path('imagenes/'.$year.'/'.$name_month),0777,true);
            }
            if(!File::exists(public_path('imagenes/miniatura/'.$year.'/'.$name_month))){
                File::makeDirectory(public_path('imagenes/miniatura/'.$year.'/'.$name_month),0777,true);
            }
        }
        else{
            $path=public_path().'/documentos/'.$year.'/'.$name_month.'/'.$nombre;
            $pathmini=public_path().'/documentos/miniatura/'.$year.'/'.$name_month.'/'.$nombre;
            if(!File::exists(public_path('documentos/'.$year.'/'.$name_month))){
                File::makeDirectory(public_path('documentos/'.$year.'/'.$name_month),0777,true);
            }
            if(!File::exists(public_path('documentos/miniatura/'.$year.'/'.$name_month))){
                File::makeDirectory(public_path('documentos/miniatura/'.$year.'/'.$name_month),0777,true);
            }
        }

        $image=Image::make($file);
        $miniatura=Image::make($file);
        $miniatura->resize(100,100);
        $image->save($path.'.jpg');
        $miniatura->save($pathmini.'.jpg');
        $im=file_get_contents($path.'.jpg');
        $bytes=base64_encode($im);

        $temporal=new Temporal();
        $temporal->bytes=$bytes;
        if($type=="planilla"){
            $temporal->image='/imagenes/'.$year.'/'.$name_month.'/'.$nombre.'.jpg';
            $temporal->minimagen='/imagenes/miniatura/'.$year.'/'.$name_month.'/'.$nombre.'.jpg';
        }else{
            $temporal->image='/documentos/'.$year.'/'.$name_month.'/'.$nombre.'.jpg';
            $temporal->minimagen='/documentos/miniatura/'.$year.'/'.$name_month.'/'.$nombre.'.jpg';
        }

        $temporal->tipo=$type;        
        $temporal->user_id=Auth::user()->id;

        $temporal->save();
        return response()->json(['ok'=>true]);

        }catch(Exception $e){
            return response()->json(['error'=>"error..."]);
        }
        
    }

    public function subir(){

        try{
            $tipo=Input::get('tipo');
            $res1 = $res2 = [];
            $token=Input::get('_token');
            for($i=0;$i<count(Input::file('imagen'));$i++){
                if(file_exists(Input::file('imagen')[0])){
                    $file=Input::file('imagen')[$i];
                    $nombre = $file->getClientOriginalName();
                    $ctime=$file->getCTime();
                    $nombre=base64_encode($nombre.$ctime);
                    $year=Carbon::now()->year;
                    $name_month=Config::get('constants.months.'.Carbon::now()->month);
                    if($tipo=="planilla"){
                        $path=public_path().'/imagenes/'.$year.'/'.$name_month.'/'.$nombre;
                        $pathmini=public_path().'/imagenes/miniatura/'.$year.'/'.$name_month.'/'.$nombre;
                        if(!File::exists(public_path('imagenes/'.$year.'/'.$name_month))){
                            File::makeDirectory(public_path('imagenes/'.$year.'/'.$name_month),0777,true);
                        }
                        if(!File::exists(public_path('imagenes/miniatura/'.$year.'/'.$name_month))){
                            File::makeDirectory(public_path('imagenes/miniatura/'.$year.'/'.$name_month),0777,true);
                        }
                    }
                    else{
                        $path=public_path().'/documentos/'.$year.'/'.$name_month.'/'.$nombre;
                        $pathmini=public_path().'/documentos/miniatura/'.$year.'/'.$name_month.'/'.$nombre;
                        if(!File::exists(public_path('documentos/'.$year.'/'.$name_month))){
                            File::makeDirectory(public_path('documentos/'.$year.'/'.$name_month),0777,true);
                        }
                        if(!File::exists(public_path('documentos/miniatura/'.$year.'/'.$name_month))){
                            File::makeDirectory(public_path('documentos/miniatura/'.$year.'/'.$name_month),0777,true);
                        }
                    }

                    $image=Image::make($file);
                    $miniatura=Image::make($file);
                    $miniatura->resize(100,100);

                    $image->save($path.'.jpg');
                    $miniatura->save($pathmini.'.jpg');
                    $im=file_get_contents($path.'.jpg');
                    $bytes=base64_encode($im);
                    $temporal=new Temporal();
                    $temporal->bytes=$bytes;
                    if($tipo=="planilla"){
                        $temporal->image='/imagenes/'.$year.'/'.$name_month.'/'.$nombre.'.jpg';
                        $temporal->minimagen='/imagenes/miniatura/'.$year.'/'.$name_month.'/'.$nombre.'.jpg';
                    }else{
                        $temporal->image='/documentos/'.$year.'/'.$name_month.'/'.$nombre.'.jpg';
                        $temporal->minimagen='/documentos/miniatura/'.$year.'/'.$name_month.'/'.$nombre.'.jpg';
                    }
                    $temporal->tipo=$tipo;
                    $temporal->user_id=Auth::user()->id;
                    $temporal->save();
                    $key=$temporal->id;
                    $url = \Illuminate\Support\Facades\Request::root().'/eliminararchivo/'.$temporal->id;
                    $res1[$i] = \Illuminate\Support\Facades\Request::root().$temporal->image;
                    $res2[$i] = ['caption' => $temporal->image, 'size' => 732762, 'width' => '120px', 'url' => $url, 'key' => $key,'extra'=>['_token'=>$token]];


                }
                else{
                    $output = ['error'=>"Error el archivo no es valido"];
                    return json_encode($output);
                }
            }
            return json_encode([
                'initialPreview' => $res1,
                'initialPreviewConfig' => $res2,
                'append' => true
            ]);

        }catch (\Exception $e){
            $output = ['error'=>"Error al almacenar las imagenes intente de nuevo"];
            return json_encode($output);
        }
    }
    public function eliminar($id){

        $img=Temporal::find($id);
        File::delete(public_path().$img->image);
        File::delete(public_path().$img->minimagen);
        $img->delete();
        $output = [];
        return json_encode($output);
    }
    public function cargarplanilla(){
        $planillas=Planilla::all();
        
        try{
            if(count($planillas)>0){
            foreach($planillas as $pla){
                $ruta=explode('/',$pla->image);
                $year=$ruta[2];
                $name_month=$ruta[3];
                if(!File::exists(public_path('imagenes/'.$year.'/'.$name_month))){
                    File::makeDirectory(public_path('imagenes/'.$year.'/'.$name_month),0777,true);
                }
                if(!File::exists(public_path('imagenes/miniatura/'.$year.'/'.$name_month))){
                    File::makeDirectory(public_path('imagenes/miniatura/'.$year.'/'.$name_month),0777,true);
                }
                $path=public_path().$pla->image;
                $pathmini=public_path().$pla->minimagen;
                $Base64Img = base64_decode($pla->bytes);
                file_put_contents($path,$Base64Img);
                file_put_contents($pathmini,$Base64Img);
            }

            Session::flash('noticie','Las planillas han sido cargadas exitosamente');
            }
            else{
                Session::flash('error','no exiten planilla disponibles');
            }
        }catch (\Exception $e){
            Session::flash('error','Algo ha salido mal al cargar planillas, intente de nuevo por favor');
        }
        $planillas=Documento::all();
        try{
            if(count($planillas)>0){
            foreach($planillas as $pla){
                $ruta=explode('/',$pla->image);
                $year=$ruta[2];
                $name_month=$ruta[3];
                if(!File::exists(public_path('documentos/'.$year.'/'.$name_month))){
                    File::makeDirectory(public_path('documentos/'.$year.'/'.$name_month),0777,true);
                }
                if(!File::exists(public_path('documentos/miniatura/'.$year.'/'.$name_month))){
                    File::makeDirectory(public_path('documentos/miniatura/'.$year.'/'.$name_month),0777,true);
                }
                $path=public_path().$pla->image;
                $pathmini=public_path().$pla->minimagen;
                $Base64Img = base64_decode($pla->bytes);
                file_put_contents($path,$Base64Img);
                file_put_contents($pathmini,$Base64Img);
            }

            Session::flash('noticie','Los documentos han sido cargadas exitosamente');
            return redirect()->back();
            }
            else{
                Session::flash('error','no exiten documentos disponibles');
                return redirect()->back();
            }
        }catch (\Exception $e){
            Session::flash('error','Algo ha salido mal al cargar documentos, intente de nuevo por favor');
            return redirect()->back();
        }

    }
}
