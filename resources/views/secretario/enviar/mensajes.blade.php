@extends('layouts.dashboard')

@section('title')
    enviar
@endsection

@section('style')
    @parent
    {!! Html::style('assets/build/custom/css/mycustom.css') !!}
    {!! Html::style('assets/autocomplete/jquery-ui-1.8.6.custom.css') !!}

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
                <a href="{{url('enviarplanilla')}}" class="btn btn-primary btn-block margin-bottom">Nuevo Mensaje</a>

                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Archivos</h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked">
                            <li>
                                <a href="{{url("mensajes")}}"><i class="fa fa-inbox"></i> Bandeja De Entrada
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
                        <h3 class="box-title">Bandeja De Entrada</h3>
                    </div>
                    <div class="box-body no-padding">

                        <div class="table-responsive mailbox-messages">
                            <table id="mytable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <td><b>Estado</b></td>
                                        <td><b>Desde</b></td>
                                        <td><b>De</b></td>
                                        <td><b>Mensaje</b></td>
                                        <td></td>
                                        <td><b>Fecha de envio</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($mensajes as $mens)
                                    <?php $user=Auth::user()->UserNameFromMesseger($mens->from_user_id);?>
                                    @if($mens->estado=="Recivido")
                                        <tr class="primary">
                                            <td class="success"><i class="fa fa-eye-slash"></i>{{$mens->estado}}</td>
                                            <td class="mailbox-name"><a href="{{url('leer/'.$mens->id)}}">{{$user->name}}</a></td>
                                            <td class="mailbox-name">{{$user->nombre}}</td>
                                            <td class="mailbox-subject"><b>{{$mens->asunto}}</b>
                                                @if(strlen($mens->mensaje)>35)
                                                    {{substr($mens->mensaje,0,35)}}...
                                                @else
                                                    {{$mens->mensaje}}
                                                @endif
                                            </td>
                                            <td class="mailbox-attachment"></td>
                                            <td class="mailbox-date">{{$mens->created_at}}</td>
                                        </tr>
                                    @else
                                        <tr class="warning">
                                            <td class="warning"><i class="fa fa-eye"></i>{{$mens->estado}}</td>
                                            <td class="mailbox-name"><a href="{{url('leer/'.$mens->id)}}">{{$user->name}}</a></td>
                                            <td class="mailbox-name">{{$user->nombre}}</td>
                                            <td class="mailbox-subject"><b>{{$mens->asunto}}</b>
                                                @if(sizeof($mens->mensaje)>45)
                                                    {{substr($mens->mensaje,0,45)}}
                                                @else
                                                    {{$mens->mensaje}}
                                                @endif
                                            </td>
                                            <td class="mailbox-attachment"></td>
                                            <td class="mailbox-date">{{$mens->created_at}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    @parent
    {!! Html::script('assets/internet/jQuery-Smart-Wizard/js/jquery.smartWizard.js') !!}


    <script>
        $(document).ready(function(){
            paginador('mytable');
        });
        var idImageSelected=[];
        var valueImageSelected=[];
        function clickimage(value,id){
            var bool=true;
            for(var i=0;i<idImageSelected.length;i++){
                if(idImageSelected[i]==id){
                    document.getElementById(valueImageSelected[i]).style.border='hidden';
                    valueImageSelected.splice(i,1);
                    idImageSelected.splice(i,1);
                    bool=false;
                    break;
                }
            }
            var cadena="";
            for(var i=0;i<idImageSelected.length;i++){
                cadena=cadena+valueImageSelected[i];

                if(i+1<idImageSelected.length){
                    cadena+="-";
                }
            }

            if(bool) {
                document.getElementById(value).style.border = 'solid 6px #0b0b0b';
                idImageSelected.push(id);
                valueImageSelected.push(value);
                cadena=cadena+"-"+value;
            }
            document.getElementById("lista").value=idImageSelected;
            document.getElementById('element').innerHTML=cadena;
        }
    </script>

@endsection