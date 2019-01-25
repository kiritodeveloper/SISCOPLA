@extends('layouts.dashboard')

@section('title')
    roles
@endsection

@section('style')
    @parent
    {!! Html::style('assets/build/custom/css/mycustom.css') !!}
@endsection

@section('pager-title')
    Edicion Roles
@endsection

@section('description')
    roles de personal
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>EDICION DE ROL</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="panel" align="center">
                        {!! Form::open(['route'=>['roles.update',$rol->id], 'role' => 'form', 'method' => 'put']) !!}
                        <h2 class="StepTitle" id="especifique">{{$rol->name}}</h2>
                        <div class="myscroll">
                            <table class="table">

                                <tr>
                                    <td style="background: #00a65a" colspan="3"> Permisos Administrador</td>
                                </tr>
                                @foreach($permissions as $per)
                                    <?php $cont=0 ?>
                                    @foreach($rol->permission as $rp)
                                        @if($per->id==$rp->id)
                                            <?php $cont++?>
                                            @break
                                        @endif
                                    @endforeach
                                    @if($cont==0)
                                        <tr>
                                            <td>{{$per->display_name}}</td>
                                            <td>{{$per->description}}</td>
                                            <td><input type="checkbox" name="lista[]" value="{{$per->id}}"></td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td>{{$per->display_name}}</td>
                                            <td>{{$per->description}}</td>
                                            <td><input type="checkbox" name="lista[]" value="{{$per->id}}" checked></td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr>
                                    <td>
                                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
                                    </td>
                                    <td><a href="{{url('roles')}}" class="btn btn-danger"><i class="fa fa-close"></i> Cancelar</a></td>
                                </tr>
                            </table>
                        </div>
                        {!! Form::close() !!}
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