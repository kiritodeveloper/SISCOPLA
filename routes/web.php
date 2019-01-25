<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware'=>['web','guest']],function() {
    Route::get('/', function () {
        return view('login.login');
    });

});
Route::post('login','LoginController@login');
Route::get('logout','LoginController@logout');
Route::get('inicio','LoginController@inicio');

Route::group(['middleware'=>['web','auth',"permission:admin-role"]],function(){
    Route::resource("roles","RolesController");
    Route::get('eliminarol', 'RolesController@eliminar');
    Route::get('addRole/{id}','RolesController@AddRole');
    Route::post('saverol/{id}','RolesController@SaveRol');
});
Route::group(['middleware'=>['web','auth',"permission:admin-users"]],function(){
    Route::resource('user','UserController');
    Route::get('getusername','UserController@generate_username');
    Route::get('user_excel','UserController@excel');
    Route::any('deleteuser','UserController@eliminar');
    Route::any('altauser','UserController@alta');
    Route::get('usuariosdel','UserController@eliminados');
});

Route::group(['middleware'=>['web','auth',"permission:admin-direccion"]],function() {
    Route::resource('unidad', 'UnidadController');
    Route::any('deleteunidad', 'FacultadController@eliminar');
    Route::get('unidads/{id}', 'UnidadController@dependientes');
});
Route::group(['middleware'=>['web','auth',"permission:admin-facultades"]],function() {
    Route::resource('facultad', 'FacultadController');
    Route::any('deletefacultad', 'FacultadController@eliminar');
    Route::get('facultads/{id}', 'FacultadController@carreras');
    Route::get('cargarplanilla', 'PlanillaController@cargarplanilla');
});
Route::group(['middleware'=>['web','auth','permission:planillas']],function(){
    Route::resource('planilla','PlanillaController');

});


Route::group(['middleware'=>['web','auth','permission:mensajeria']],function() {
Route::get('mensajes','EnviarController@mensajes');
Route::get('enviados','EnviarController@enviados');
Route::get('enviarplanilla','EnviarController@index');
    Route::post('enviar', 'EnviarController@store');
});


Route::post('submitimagen','PlanillaController@submitimagen');
Route::get('verplanilla','PlanillaController@verplanilla');

Route::get('leer/{id}', 'EnviarController@leer');
Route::get('leerenviados/{id}', 'EnviarController@leerenviados');
Route::get('descargar/{id}', 'EnviarController@descargar');

Route::group(['middleware'=>['web','auth','permission:ayuda']],function(){
    Route::get('help',function(){
        return view('secretario.help.index');
    });
});
Route::group(['middleware'=>['web','auth','permission:documentos']],function() {
    Route::resource('archi', 'DocumentosController');
    Route::get("eliminartodo", 'DocumentosController@eliminarimagenes');
    Route::get('verdocumento', 'DocumentosController@verdocumento');
});

Route::group(['middleware'=>['web','auth','permission:revision']],function(){//'personal'
    Route::get('revisar','DocumentosController@revisar');

    Route::get('revisar/{id}','DocumentosController@revisarxusuario');
});


Route::any('subir-planilla','PlanillaController@subir');
Route::post('eliminararchivo/{id}','PlanillaController@eliminar');

Route::get('getUnidadDependiente',function(){
    $id=\Illuminate\Support\Facades\Input::get('option');
    $unidad=\App\Oficina::where('oficina_id',$id)->get();
    foreach($unidad as $a){
        $json[]=array("id"=>$a->id,"name"=>$a->name);
    }
    return $json;
});