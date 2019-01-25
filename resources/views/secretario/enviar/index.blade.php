@extends('layouts.dashboard')

@section('title')
    enviar
@endsection

@section('style')
    @parent
    {!! Html::style('assets/build/custom/css/mycustom.css') !!}

    <style type="text/css">
        .myscroll {
            border: solid white 1px;
            overflow: scroll;
            height: 170px;
        }
    </style>
    <style type="text/css">

        .wrapper2 {
            background:#EFEFEF;
            box-shadow: 1px 1px 10px #999;
            margin: auto;
            text-align: center;
            position: relative;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            margin-bottom: 20px !important;
            width: 100%;
            padding-top: 5px;
        }
        .scrolls2 {
            overflow-x: scroll;
            overflow-y: hidden;
            height: 170px;
            white-space:nowrap
        }
        .middle {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%)
}
.image-form-env:hover .middle {
  opacity: 1;
}
    </style>

    {!! Html::style('assets/select2/select2.css') !!}

@endsection

@section('pager-title')
    Enviar
@endsection

@section('description')
    Enviar mensaje
@endsection

@section('content')
    <section class="content">
            <div class="row">
                <div class="col-md-3">
                    <a href="{{ url('mensajes') }}" class="btn btn-primary btn-block margin-bottom">Volver a la Bandeja De Entrada</a>
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Archivos</h3>
                        </div>
                        <div class="box-body no-padding">
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="{{url("mensajes")}}"><i class="fa fa-inbox"></i> Bandeja De Entrada
                                        @if(count(Auth::user()->MER())>0)
                                        <span class="label label-primary pull-right">{{count(Auth::user()->MER())}}</span>
                                        @endif
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('enviados')}}"><i class="fa fa-send"></i> Enviados
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nuevo Mensaje</h3>
                        </div>

                        {!! Form::open(['url'=>'enviar', 'role' => 'form', 'method' => 'post']) !!}
                        <div class="box-body">
                            <div class="form-group">
                                <select name="to_user_id[]" multiple class="form-control" id="oficinas">
                                    <option value=""></option>
                                    @foreach($oficinas as $item)
                                        <option value="{{$item->id}}">{{$item->name}} - {{$item->nombre}} {{$item->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="alert alert-success" id="users" style="display: none;">

                            </div>
                            <div class="form-group">
                                <input class="form-control" name="asunto" placeholder="Asunto:">
                            </div>
                            <div class="form-group">
                            <textarea id="compose-textarea" name="mensaje" class="form-control" style="height: 300px"></textarea>
                                <input type="hidden" id="lista" name="list">
                            </div>
                            <div class="form-group">
                                <a id="buton-image" class="btn btn-md btn-success"><i class="fa fa-paperclip"></i></a>
                                <a href="{{url('archi')}}" class="btn btn-success"><i class="fa fa-print"></i> Escannear/Subir</a>
                            </div>

                                <div class="row" id="element">

                                </div>

                        </div>
                        <div class="box-footer">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Enviar</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        <div class="row" id="imagenes-lay" style="display:none;">
            <div class="row">
            <div class="col-md-6">
            {!! Form::open(['url'=>'enviarplanilla','method'=>'get','role'=>'form']) !!}
                <table class="table" width="100%">
                    <tr>
                        <td width="18%">Inicio</td>
                        <td width="18%"><input type="date" name="inicio" class="form-control" value="{{$inicio}}"></td>
                        <td width="18%">Fin</td>
                        <td width="18%"><input type="date" name="final" class="form-control" value="{{$final}}"></td>
                        <td width="18%">Nombre</td>
                        <td width="18%"><input type="text" name="nombre" value="{{$nombre}}"></td>
                        <td><button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Buscar</button></td>
                    </tr>
                </table>
            {!! Form::close() !!}
            </div>
            </div>
            <div class="row">
                <div class="col-md-12">
            <div class="wrapper2">
                <div class="scrolls2">
                    @for($i=0;$i<count($imagens);$i++)
                        <a id="carousel-selector-{{$i}}" >
                      {!! Html::image($imagens[$i]->image,null,['class'=>'image-form-env',"width"=>"200px","height"=>"110px","id"=>"img".$imagens[$i]->id,"onclick"=>"clickimage(this.id,".$imagens[$i]->id.",'".$imagens[$i]->nombre."')",'tittle'=>$imagens[$i]->nombre]) !!}
                      </a>
                    @endfor
                </div>
            </div>
        </div>
            </div>
        </div>
        </section>


@endsection

@section('script')
    @parent
    {!! Html::script('assets/select2/select2.full.min.js') !!}
    {!! Html::script('assets/select2/select2.full.js') !!}
    {!! Html::script('assets/select2/select2.js') !!}
    {!! Html::script('assets/select2/select2.min.js') !!}


    <script type="text/javascript">
        $(document).ready(function() {
            paginador('mytable');
            $('#oficinas').select2({
                placeholder:"Seleccione Secretaria de destino"
            });
        });
    </script>
    <script>

        var nn=0;
        $("#buton-image").click(function(){
            if(nn%2==0){
                $("#imagenes-lay").css('display','block');
            }else{
                $("#imagenes-lay").css('display','none');
            }
            nn++;
        });
    </script>
    <script>
        var idImageSelected=[];
        var valueImageSelected=[];
        var ImageSelected=[];
        var nameSelected=[];
        function clickimage(value,id,nombre){
            
            var bool=true;
            for(var i=0;i<idImageSelected.length;i++){
                if(idImageSelected[i]==id){
                    document.getElementById(valueImageSelected[i]).style.border='hidden';
                    document.getElementById(value).style.opacity = '1';
                    valueImageSelected.splice(i,1);
                    idImageSelected.splice(i,1);
                    ImageSelected.splice(i,1);
                    nameSelected.splice(i,1);
                    bool=false;
                    break;
                }
            }
            var cadena="";
            for(var i=0;i<idImageSelected.length;i++){
                cadena=cadena+"<span class='alert' style='background: #31b0d5;color:#fff;'>"+nameSelected[i]+"</span>";
            }

            if(bool) {
                document.getElementById(value).style.border = 'solid 3px #d50000';
                document.getElementById(value).style.opacity = '0.5';
                idImageSelected.push(id);
                valueImageSelected.push(value);
                nameSelected.push(nombre);
                ImageSelected.push(document.getElementById(value).src);
                cadena=cadena+"<span class='alert' style='background: #31b0d5;color:#fff;'>"+nombre+"</span>";
            }
            document.getElementById("lista").value=idImageSelected;
            document.getElementById('element').innerHTML=cadena;
        }
        var users=[];
        function agregar(id,nombre,unidad){
            var user={id:id,nombre:nombre,unidad:unidad};
            var x=[];
            var bool=true;
            for(var i=0;i<users.length;i++){
                if(id==users[i].id){
                    users.splice(i,1);
                    bool=false;
                    break;
                }
            }
            if(bool){
            users.push(user);
            }
            for(var i=0;i<users.length;i++){
                x.push(users[i].nombre);
            }
            if(users.length>0){
                document.getElementById('users').innerHTML=x.join(' * ');
                document.getElementById('users').style.display="block";
            }else{
                document.getElementById('users').style.display="none";
            }
        }
    </script>

@endsection