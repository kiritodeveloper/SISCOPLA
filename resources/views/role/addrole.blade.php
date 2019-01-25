@extends('layouts.dashboard')

@section('title')
    roles
@endsection

@section('style')
    @parent
    {!! Html::style('assets/build/custom/css/mycustom.css') !!}
@endsection

@section('pager-title')
   Agregar Roles
@endsection

@section('description')
    roles de personal
@endsection

@section('content')
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Agregar/Quitar Roles del usuario {{$user->nombre_usuario}}</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        {!! Form::open(["url"=>"saverol/".$user->id,'method'=>"post","role"=>"form"]) !!}
                        <table class="table table-responsive table-bordered" style="background: #00c0ef">
                            <thead style="background: #000080;color:#fff">
                            <tr>
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Permisos</th>
                                <th>Agregar/Quitar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $rol)
                                <tr>
                                    <td rowspan="{{count($rol->permission)+1}}">{{$rol->name}} </td>
                                    <td rowspan="{{count($rol->permission)+1}}">{{$rol->description}}</td>
                                    @if(count($rol->permission)>0)
                                </tr>
                                <?php $cont=0?>
                                @foreach($rol->permission as $per)
                                    <tr>
                                        <td>{{$per->display_name}}</td>
                                        @if($cont==0)
                                            <td rowspan="{{count($rol->permission)}}">
                                                @if($rol->state==true)
                                                    <input type="checkbox" name="roles[]" value="{{$rol->id}}" checked>
                                                @else
                                                    <input type="checkbox" name="roles[]" value="{{$rol->id}}">
                                                @endif
                                            </td>
                                            <?php $cont=1?>
                                        @endif
                                    </tr>
                                @endforeach
                                @else
                                    <td>Ninguno</td>
                                    <td>
                                        @if($rol->state==true)
                                            <input type="checkbox" name="roles[]" value="{{$rol->id}}" checked>
                                        @else
                                            <input type="checkbox" name="roles[]" value="{{$rol->id}}">
                                        @endif
                                    </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                        <a href="{{url("/user")}}" class="btn btn-round" style="background: #FF1800;color: #000"> ir atras</a>
                            <button class="btn btn-round" type="submit" style="background: #098d38;color: #fff"><i class="fa fa-save"></i> Guardar</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @parent
@endsection