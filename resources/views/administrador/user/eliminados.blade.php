@extends('layouts.dashboard')

@section('title')
    Incio
@endsection

@section('style')
    @parent
    {!! Html::style('assets/build/custom/css/mycustom.css') !!}
@endsection

@section('pager-title')
    Inicio
@endsection

@section('description')
    Universidad
@endsection

@section('content')
    <div class="row">
        <div class="col-md-7 col-xs-12">
            <div class="panel panel-primary">
                <div class="panel panel-heading">
                    <h2>Usuarios de Baja del Sistema</h2>

                    
                </div>
                <div class="panel panel-boding">
                    <table id="mydatatable" class="table table-bordered table-responsive">
                    <thead>
                    <tr style="background: #001F3F;color:#fff">
                        <td>Nombre Completo</td>
                        <td>Celular</td>
                        <td>Email</td>
                        <td>Rol</td>
                        <td>Opciones</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $u)
                        <tr data-id="{{$u->id}}">
                            <td>{{$u->name}} {{$u->last_name}}</td>
                            <td>{{$u->celular}}</td>
                            <td>{{$u->email}}</td>
                            <td>{{$u->rol}}</td>
                            <td>
                                <div class="form-group">
                            

                                <a  class="btn btn-success btn-xs" onclick="daralta('{{$u->id}}')"><i class="fa fa-user"></i>dar de alta</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        
        
        
    </div>
@endsection

@section('script')
    @parent
    {!! Html::script('assets/internet/jQuery-Smart-Wizard/js/jquery.smartWizard.js') !!}
    <script type="text/javascript">
    function daralta(id){
            var a=confirm("esta serguro de dar de alta a este usuario?");
            if(a==true)
            {
                $.ajax({
                    url:'{{url('altauser')}}',
                    type:'get',
                    data:{id:id},
                    success:function(data){
                        if(data=='0'){
                            setTimeout("location.reload()",1000);
                        }else{
                            setTimeout("location.reload()",1000);
                        }

                    }
                });
            }
        }
    </script>
@endsection