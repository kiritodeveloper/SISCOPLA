@extends('layouts.dashboard')

@section('title')
    enviar
@endsection

@section('style')
    @parent
    {!! Html::style('assets/build/custom/css/mycustom.css') !!}
    {!! Html::style('assets/photos/css/prettyPhoto.css') !!}
    {!! Html::style('assets/photos/css/main2.css') !!}
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
                <a href="{{ url('mensajes') }}" class="btn btn-primary btn-block margin-bottom">Volver a la Bandeja De Entrada</a>
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
                        <h3 class="box-title">Leer Mensaje</h3>
                    </div>
                    <div class="box-body no-padding">
                        <div class="mailbox-read-info alert alert-info">
                            <h3>A: {{$user->nombre}}</h3>
                            <h3>Carrera: {{$user->name}}</h3>
                            <h5>Asunto: {{$mensaje->asunto}}
                                <span class="pull-right">{{$mensaje->created_at}}</span></h5>
                        </div>
                        <div class="mailbox-read-message">
                            <h3>
                          {{$mensaje->mensaje}}
                            </h3>
                        </div>
                    </div>
                    <div class="box-footer">
                        <ul class="mailbox-attachments clearfix">
                            @foreach($mensajes as $mens)
                            <li>
                                <span class="mailbox-attachment-icon has-img">
                                    {!! Html::image($mens->image,null,["title"=>"imagen",'width'=>"140px","heigth"=>"120px"]) !!}
                                </span>
                                <div class="mailbox-attachment-info">

                                    <span class="mailbox-attachment-size">
                                        descargar

                                      <a href="{{url("descargar/".$mens->pid)}}" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                                    </span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- /. box -->
            </div>
        </div>
    </section>

@endsection

@section('script')
    @parent
    {!! Html::script('assets/internet/jQuery-Smart-Wizard/js/jquery.smartWizard.js') !!}
    {!! Html::script('assets/photos/js/jquery.prettyPhoto.js') !!}
    {!! Html::script('assets/photos/js/main.js') !!}


@endsection