@extends('layouts.dashboard')

@section('title')
    Incio
@endsection

@section('style')
    @parent
    {!! Html::style('assets/inputfile/css/fileinput.min.css') !!}
    {!! Html::script('assets/inputfile/js/plugins/jquery.min.js') !!}
    {!! Html::script('assets/bootstrap337/js/bootstrap-modal.js') !!}

    {!! Html::script('assets/inputfile/js/fileinput.js') !!}
    {!! Html::script('assets/inputfile/js/locales/es.js') !!}

@endsection

@section('pager-title')
    Inicio
@endsection

@section('description')
    Universidad
@endsection

@section('content')
    <div class="row container-fluid">
        <div class="row">
            <div class="col-md-12 col-xs-12 sidebar">

                <table class="table">
                    {!! Form::open(['route'=>'archi.store', 'role' => 'form', 'method' => 'post','files'=>"true"]) !!}
                    <tr>
                        <td>Nombre</td>
                        <td><input type="text" name="nombre" class="form-control"></td>
                        <td>
                            <button type="submit" class="btn btn-success"> <i class="fa fa-save"></i> Guardar</button>
                        </td>
                    </tr>
                    {!! Form::close() !!}
                    <tr>
                        <td>Documento</td>
                        <td>
                        <input id="imagen" name="imagen[]" type="file" multiple class="file-loading" onchange="">
                            <input type="hidden" name="csrf-token" content="{{ csrf_token() }}">
                            <script>
                                var $input = $("#imagen");
                                $input.fileinput({
                                    uploadUrl: "{{url('subir-planilla')}}",
                                    uploadAsync: false,
                                    minFileCount: 1,
                                    maxFileCount: 25,
                                    allowedFileExtensions:['jpg','jpeg','png','bmc'],
                                    @if(count($res1)>0)
                                    initialPreview:[
                                        @foreach($res1 as $r)
                                        "{{Request::root().$r}}",
                                        @endforeach
                                    ],
                                    initialPreviewConfig: [
                                        @foreach($res2 as $r)
                                        {caption: "{{$r['caption']}}", size: "{{$r['size']}}", width: "{{$r['width']}}", url: "{{$r['url']}}", key: "{{$r['key']}}",extra:{_token:"{{csrf_token()}}"}, },
                                        @endforeach
                                    ],
                                    @endif
                                    overwriteInitial: false,
                                    initialPreviewAsData:true,
                                    uploadExtraData:function() {
                                                        return {
                                                            _token: '{{csrf_token()}}',
                                                            tipo:'documento'
                                                        };
                                                    }
                                }).on("filebatchselected", function(event, files) {
                                    $input.fileinput("upload");
                                }).on('fileuploaded', function(event, data, previewId, index) {
                                    console.log(data.response.initialPreviewConfig.url);

                                });

                            </script></td>
                        <td><button type="button" class="btn btn-success" onclick="scannear()"><i class="fa fa-print"></i> Escanear</button>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><a href="{{url('eliminartodo')}}" class="btn btn-danger"><i class="fa fa-trash"></i> Eliminar Todas las imagenes pre cargadas</a></td>
                    </tr>
                </table>
<div>
    <script type="text/javascript">
        function scannear(){
            loadDoc("ws://127.0.0.1:9000", myFunction);
        }
        function loadDoc(url, cFunction) {
            var cant=0;
            var cadena="";
            if ("WebSocket" in window) {
                var ws = new WebSocket(url);
                ws.onopen = function () {
                    alert("Esta a punto de escanear documentos, asegurese de que la impresora este encendida");
                    ws.send("scannear");
                };
                ws.onerror = function (error) {
                    console.log('WebSocket Error');
                };
                ws.onmessage = function (evt) {
                    cadena+=evt.data;
                    cant++;
                    if(cant==101){
                        cFunction(cadena);
                    }
                };
                ws.onclose = function () {
                    $("#mymodal").modal();
                };
            }else{
                $("#mymodalchrome").modal();
            }
        };
    </script>
    <script type="text/javascript">
        function myFunction(cadena) {
            console.log(cadena);
            $.ajax({
                url:'{{url('submitimagen')}}',
                type:'post',
                data:{imagen:cadena,_token:'{{csrf_token()}}',type:"documento"},
                success:function(data){
                    if(data.ok){
                        setTimeout('location.reload()',1000);
                    }else{
                        alert("error");
                    }
                },
                error:function(error){
                    console.log("error:"+error);
                    alert(error);
                }
            });
        }
                    </script>
</div>

            </div>
        </div>


        <div class="row">
            @foreach($documentos as $doc)
            <div class="col-md-4">
                <div class="thumbnail">
                    <a href="/w3images/lights.jpg">
                        <img src="/w3images/lights.jpg" alt="Lights" style="width:100%">
                        <div class="caption">
                            <p>Lorem ipsum...</p>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

    </div>

    <div>
        <div id="mymodal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header" style="background: #0063dc">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2"><b>Descargar</b></h4>
                    </div>
                    <div class="modal-body" style="background: #F5F7FA;">
                        <center>
                            <img src="image/log.png" width="200px" height="200px">
                        </center>
                        <div class="alert alert-danger">
                            Descargue la siguiente aplicacion, en caso de tener el programa inicie el servicio e intentelo de nuevo
                        </div>
                        <center>
                            <a href="{{url('/componente/setup.exe')}}" target="_blank" class="btn btn-success"><i class="fa fa-download"></i>Descargar aplicacion</a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="mymodalchrome" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header" style="background: #0063dc">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2"><b>Descargar</b></h4>
                </div>
                <div class="modal-body" style="background: #F5F7FA;">
                    <center>
                        <img src="image/chrome.png" width="200px" height="200px">
                    </center>
                    <div class="alert alert-danger">
                        Descargue Chrome, y vuelva a abrir el sistema en ese navegador
                    </div>
                    <center>
                        <a href="https://www.google.com/chrome/browser/desktop/index.html" target="_blank" class="btn btn-success"><i class="fa fa-download"></i>Descargar Google Chrome</a>
                    </center>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @parent
    {!! Html::script('assets/photos/js/jquery.prettyPhoto.js') !!}
    {!! Html::script('assets/photos/js/main.js') !!}

    <script>
        function handleFileSelect(evt) {
            var files = evt.target.files;
            for (var i = 0, f; f = files[i]; i++) {
                if (!f.type.match('image.*')) {
                    continue;
                }
                var reader = new FileReader();
                reader.onload = (function(theFile) {
                    return function(e) {
                        var span = document.createElement('span');
                        span.innerHTML=['<div class="col-md-2 col-xs-3"><div class="thumbnail"><img class="thumb" style="width:100%" src="', e.target.result,'" title="', escape(theFile.name), '"/><br /><div class="caption"> <p>','Tama&ntilde;o: ', escape(theFile.size), ' bytes <br> MIME: ', escape(theFile.type),'</p></div></div></div>'].join('');
                        document.getElementById('list-miniatura').insertBefore(span, null);
                    };
                })(f);
                reader.readAsDataURL(f);
            }
        }
        document.getElementById('files').addEventListener('change', handleFileSelect, false);
    </script>
@endsection