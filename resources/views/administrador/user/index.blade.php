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
                    <h2>Usuarios del Sistema</h2>

                    
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
                        <tr>
                            <td>{{$u->name}} {{$u->last_name}}</td>
                            <td>{{$u->celular}}</td>
                            <td>{{$u->email}}</td>
                            <td><a href="{{url('addRole',$u->id)}}" class="btn btn-round btn-sm btn-warning" data-toggle="tooltip" data-placement="left" title="Asignar Rol"><i class="fa fa-cog"></i></a></td>
                            <td>
                                <div class="form-group">
                                {!! Form::open(["route"=>["user.edit",$u->id],"role"=>"form","method"=>'get']) !!}
                                <button type="submit" class="btn btn-warning btn-xs" ><i class="fa fa-edit"></i></button>
                                {!! Form::close() !!}

                                <a  class="btn btn-danger btn-xs" onclick="eliminar('{{$u->id}}')"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        @include('administrador.user.create')
        
        
    </div>
@endsection

@section('script')
    @parent
    {!! Html::script('assets/internet/jQuery-Smart-Wizard/js/jquery.smartWizard.js') !!}
    <script>
        $(document).ready(function() {
            $('#wizard_verticle').smartWizard({
                transitionEffect: 'slide',
                labelNext:'Siguiente',
                labelPrevious:'Anterior',
                labelFinish:'Guardar'
            });
            $('.buttonFinish').addClass('btn btn-info');
            $('.buttonNext').addClass('btn btn-success');
            $('.buttonPrevious').addClass('btn btn-success');

            $('#unidad_mayor').attr('disabled',true);
            $('#unidad_dependiente').attr('disabled',true);
            $('#facultad').attr('disabled',true);
            $('#carrera').attr('disabled',true);
            paginador('mydatatable');
        });
    </script>

    <script>

        function getpassword(){
            var nombre=document.getElementById("name").value;
            var appat=document.getElementById("last_name").value;
            var ci=document.getElementById("ci").value;
            var pass=ci[0]+nombre[0]+ci[ci.length-1]+nombre[nombre.length-1];
            if(appat.length!=0){
                pass=appat[appat.length-1]+pass+appat[0];
            }
            document.getElementById("password").value=pass;
            document.getElementById("pass").value=pass;
            $.ajax({
                url:'{{url('getusername')}}',
                type:'get',
                data:{nombre:nombre,apellido:appat,ci:ci},
                success:function(data){
                    document.getElementById("username").value=data;
                    document.getElementById("userna").value=data;
                }
            });


        }

        $('#unidad_mayor').change(function() {
            if($(this).val()!=''){
                $.get("{{ url('getUnidadDependiente')}}",
                        { option: $(this).val() },
                        function(data) {
                            $('#unidad_dependiente').empty();
                            $('#unidad_dependiente').append("<option value=''>Seleccione</option>");

                            for(i=0;i<data.length;i++){
                                $('#unidad_dependiente').append("<option value='" + data[i]["id"] + "'>" + data[i]["name"] + "</option>");
                            }
                        });
            }else{
                $('#unidad_dependiente').empty();
                $('#unidad_dependiente').append("<option value=''>Seleccione</option>");
            }
        });
        $('#facultad').change(function() {
            if($(this).val()!=''){
                $.get("{{ url('getUnidadDependiente')}}",
                        { option: $(this).val() },
                        function(data) {
                            $('#carrera').empty();
                            $('#carrera').append("<option value=''>Seleccione</option>");

                            for(i=0;i<data.length;i++){
                                $('#carrera').append("<option value='" + data[i]["id"] + "'>" + data[i]["name"] + "</option>");
                            }
                        });
            }else{
                $('#carrera').empty();
                $('#carrera').append("<option value=''>Seleccione</option>");
            }
        });




        function sele(value){
            if(value=="Unidad Mayor"){
                $('#unidad_mayor').attr('disabled',false);
                $('#unidad_dependiente').attr('disabled',true);
                $('#facultad').attr('disabled',true);
                $('#carrera').attr('disabled',true);
                document.getElementById('mensaje').innerHTML="Selecione Unidad Mayor";

            }
            if(value=="Unidad Dependiente"){
                $('#unidad_mayor').attr('disabled',false);
                $('#unidad_dependiente').attr('disabled',false);
                $('#facultad').attr('disabled',true);
                $('#carrera').attr('disabled',true);
                document.getElementById('mensaje').innerHTML="Selecione Unidad Dependiente";


            }
            if(value=="Facultad"){
                $('#unidad_mayor').attr('disabled',true);
                $('#unidad_dependiente').attr('disabled',true);
                $('#facultad').attr('disabled',false);
                $('#carrera').attr('disabled',true);
                document.getElementById('mensaje').innerHTML="Selecione Facultad";

            }
            if(value=="Carrera"){
                $('#unidad_mayor').attr('disabled',true);
                $('#unidad_dependiente').attr('disabled',true);
                $('#facultad').attr('disabled',false);
                $('#carrera').attr('disabled',false);
                document.getElementById('mensaje').innerHTML="Selecione Carrera";


            }
        }

        $(document).ready(function(){
            $("#activar").click(function(){
                document.getElementById('edit').style.display="block";
                document.getElementById('create').style.display="none";
            });
        });
        function eliminar(id){
            var a=confirm("esta serguro eliminar este usuario?");
            if(a==true)
            {
                $.ajax({
                    url:'{{url('deleteuser')}}',
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