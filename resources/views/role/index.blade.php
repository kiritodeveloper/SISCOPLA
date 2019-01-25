@extends('layouts.dashboard')

@section('title')
    roles
@endsection

@section('style')
    @parent
    {!! Html::style('assets/build/custom/css/mycustom.css') !!}
@endsection

@section('pager-title')
    Roles
@endsection

@section('description')
    roles de personal
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>ROLES DE USUARIO</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="panel" align="center">
                        <a href="{{route("roles.create")}}" class="btn btn-round" style="background: #098d38;color:#fff"><i class="fa fa-folder-open"></i> Registrar Nuevo</a>
                        <table class="table table-responsive table-bordered">
                            <thead style="background: #0c3b5e;color: #fff;">
                            <tr>
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Permisos</th>
                                <th>Opcion</th>
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
                                            <td rowspan="{{count($rol->permission)}}"><a href="{{route('roles.edit',\Illuminate\Support\Facades\Crypt::encrypt($rol->id))}}"> <i class="fa fa-plus"></i> agregar/quitar permisos</a>
                                                <br>
                                                @if($rol->id > 1)
                                                    <a class="btn" onclick="eliminar('{{$rol->id}}')"><i class="fa fa-trash">Eliminar rol</i></a>
                                                @endif
                                            </td>
                                            <?php $cont=1?>
                                        @endif
                                    </tr>
                                @endforeach
                                @else
                                    <td>Ninguno</td>
                                    <td><a href="{{route('roles.edit',\Illuminate\Support\Facades\Crypt::encrypt($rol->id))}}"> <i class="fa fa-plus"></i> agregar/quitar permisos</a>
                                        <br>
                                        @if($rol->id > 1)
                                            <a class="btn" onclick="eliminar('{{$rol->id}}')"><i class="fa fa-trash">Eliminar rol</i></a>
                                        @endif
                                    </td>
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
@endsection

@section('script')
    @parent
    <script>
        function eliminar(id){
            var bool=confirm("Seguro de eliminar este rol");
            if(bool==true){
                $.ajax({
                    url:'{{url('eliminarol')}}',
                    type:'get',
                    data:{id:id},
                    success: function (data) {
                        setTimeout('location.reload()',1000)
                    }
                });
            }else{
                alert('Operacion Cancelada');
            }
        }
    </script>
@endsection