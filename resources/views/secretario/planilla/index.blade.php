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
    {!! Html::script('assets/ping/knockout-2.1.0.js') !!}
    {!! Html::script('assets/ping/ping.js') !!}
<script type="text/javascript">
   /* var PingModel = function (servers) {
        var self = this;
        var myServers = [];
        ko.utils.arrayForEach(servers, function (location) {
            myServers.push({
                name: location,
                status: ko.observable('unchecked')
            });
        });
        self.servers = ko.observableArray(myServers);
        ko.utils.arrayForEach(self.servers(), function (s) {
            s.status('checking');
            new ping(s.name, function (status, e) {
                console.log(status);
                if(status!='responded' && status!='timeout'){
                    $("#mymodal").modal();
                    setTimeout(function(){
                        var komodel = new PingModel(['localhost:8080']);
                        ko.applyBindings(komodel);
                    },10000)
                }
            });
        });
    };
    $(document).ready(function(){
        var komodel = new PingModel(['localhost:8080']);
        ko.applyBindings(komodel);
    });*/
</script>
@endsection

@section('pager-title')
    Inicio
@endsection

@section('description')
    Universidad
@endsection

@section('content')
<?php header('Access-Control-Allow-Origin: *'); ?>
    <div class="row container-fluid">
        <div class="row">
            <div class="col-md-12 col-xs-12 sidebar">
            <div id="visto" style="display: block;">
                
            {!! Form::open(['route'=>'planilla.store', 'role' => 'form', 'method' => 'post','files'=>"true"]) !!}
                <table class="table">
                   
                    
                    <tr>
                        <td>Turno</td>
                        <td><select id="shift" name="shift" class="form-control">
                                <option value="m">Ma&ntilde;ana</option>
                                <option value="t">Tarde</option>
                                <option value="n">Noche</option>
                            </select></td>

                        <td><button class="btn btn-success" type="submit" ><i class="fa fa-save"></i> Enviar</button></td>
                    </tr>
                    <tr>
                        <td>Observaciones</td>
                        <td><textarea id="observacion" name="observacion"  cols="30" rows="3" class="form-control">Sin observaciones</textarea></td>
                        <td></td>
                    </tr>
                    
                    <tr>
                        <td>Planilla</td>
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
                                    allowedFileExtensions:['jpg','png','jpeg','bmc'],
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
                                                            tipo:'planilla'
                                                        };
                                                    }
                                }).on("filebatchselected", function(event, files) {
                                    $input.fileinput("upload");
                                }).on('fileuploaded', function(event, data, previewId, index) {
                                    console.log(data.response.initialPreviewConfig.url);

                                });

                            </script></td>
                        <td><button type="button" class="btn btn-success" onclick="scannear()"><i class="fa fa-print"></i> Escanear</button></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><a href="{{url('eliminartodo')}}" class="btn btn-danger"><i class="fa fa-trash"></i> Eliminar Todas las imagenes pre cargadas</a></td>
                    </tr>
                </table>
                {!! Form::close() !!}
                </div>
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
                                data:{imagen:cadena,_token:'{{csrf_token()}}',type:"planilla"},
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
                        <a href="{{url('/componente/setup.exe')}}" target="_blank" class="btn btn-success"><i class="fa fa-download"></i> Descargar Aplicacion</a>
                    </center>
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
                        <a href="https://www.google.com/chrome/browser/desktop/index.html" target="_blank" class="btn btn-success"><i class="fa fa-download"></i>descargar Google Chrome</a>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')


    @parent
    <script type="text/javascript">
        var bool=true;
        function cambiovista(valor){
            if(valor=="scan"){
                document.getElementById('visto').style.display="none";
                document.getElementById('oculto').style.display="block";
            }else{
                document.getElementById('visto').style.display="block";
                document.getElementById('oculto').style.display="none";
            }
        }

        /*function llamar(){
            $.ajax({
                url:'http://localhost:8080',
                type:'get',
                success:function(data){
                    myFunction(data);
                },
                error:function(){
                    $("#mymodal").modal();
                    setTimeout('llamar()',5000);
                }
            });
        }*/
        $(document).ready(function() {
            paginador('mytable');
           /* if(bool==true){
                setTimeout('llamar()',5000);
            }*/

        });
    </script>


@endsection