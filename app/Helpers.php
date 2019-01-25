<?php
/**
 * @param $imagen
 * @return string
 */
function SaveImagen(\Illuminate\Http\File $imagen){
    $file=$imagen;
    $nombre = $file->getClientOriginalName();
    $mime=$file->getMimeType();
    $extencion=explode('/',$mime);
    $ctime=$file->getCTime();
    $nombre=base64_encode($nombre.$ctime);
    $year=\Carbon\Carbon::now()->year;
    $name_month=\Illuminate\Support\Facades\Config::get('constants.months.'.\Carbon\Carbon::now()->month);
    $path=public_path().'/imagenes/'.$year.'/'.$name_month.'/'.$nombre;
    $image=\Intervention\Image\Facades\Image::make($file);
    $image->resize(600,600);
    $image->save($path.'.jpg');
    return '/imagenes/'.$year.'/'.$name_month.'/'.$nombre.'.jpg';
}