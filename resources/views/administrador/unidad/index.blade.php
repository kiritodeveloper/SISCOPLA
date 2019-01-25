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
                <h3>Unidad Administradiva</h3>
            </div>
            <div class="panel panel-boding">
                <table id="mydatatable" class="table table-bordered table-responsive table-striped">
                    <thead>
                    <tr class="success">
                        <td>Nombre</td>
                        <td>Tipo</td>
                        <td>Opciones</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($unidads as $u)
                        <tr>

                            <td><a href="{{url('unidads/'.$u->id)}}">
                                {{$u->name}}</a>
                            </td>
                            <td>{{$u->type}}</td>
                            <td>
                                {!! Form::open(["route"=>["unidad.edit",$u->id],"role"=>"form","method"=>'get']) !!}
                                <button type="submit" class="btn btn-warning btn-xs" ><i class="fa fa-edit"></i></button>
                                {!! Form::close() !!}
                                <a onclick="eliminar('{{$u->id}}')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a></td>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-5 col-xs-12">
        <div class="panel panel-primary">
            <div class="panel panel-boding">
                {!! Form::open(['route'=>'unidad.store', 'role' => 'form', 'method' => 'post']) !!}
                <div id="wizard_verticle" class="form_wizard wizard_verticle">
                    <ul class="list-unstyled wizard_steps">
                        <li>
                            <a href="#step-11">
                                <span class="step_no">1</span>
                            </a>
                        </li>
                        <li>
                            <a href="#step-22">
                                <span class="step_no">2</span>
                            </a>
                        </li>
                        <li>
                            <a href="#step-33">
                                <span class="step_no">3</span>
                            </a>
                        </li>
                    </ul>

                    <div id="step-11">
                        <h4 class="StepTitle">Lugares</h4>
                        <p class="alert alert-info">
                            Seleccione Tipo el de Unidad
                        </p>
                        <table class="table table-bordered">
                            <tr>
                                <td><label>Direccion </label></td>
                                <td><input type="radio" class="flat" name="type" id="type" value="Unidad Mayor" onclick="sele(this.value)"/></td>
                            </tr>
                            <tr>
                                <td><label>Unidad Administrativa </label></td>
                                <td><input type="radio" class="flat" name="type" id="type" value="Unidad Dependiente" onclick="sele(this.value)"/></td>
                            </tr>

                        </table>

                    </div>
                    <div id="step-22">
                        <h2 class="StepTitle" id="especifique">Especifique</h2>
                        <label class="mensaje" id="mensaje"></label>
                        <br>
                        <br>
                            <table  class="table table-bordered table-striped">
                                <tr>Direccion</tr>
                                <tr><select name="oficina_id" id="oficina_id" class="form-control" >
                                        <option value="">Seleccione Direccion</option>
                                        @foreach($unidad_mayors as $um)
                                            <option value="{{$um->id}}"> {{$um->name}}</option>
                                        @endforeach
                                    </select></tr>
                            </table>
                    </div>
                    <div id="step-33">
                        <h3 class="StepTitle" >Nombre de la Oficina</h3>

                        <br>
                        <br>
                        <table class="table table-responsive">
                            <tr>
                                <td>{!! Form::label('name','Nombre') !!}</td>
                                <td>{!! Form::text('name',null,["class"=>"form-control","placeholder"=>"Nombre de Oficina",'required']) !!}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>

    </div>
    </div>
@endsection

@section('script')
    @parent
    {!! HTML::script('assets/internet/jQuery-Smart-Wizard/js/jquery.smartWizard.js') !!}
    <script>
        $(document).ready(function() {
            $('#wizard').smartWizard();

            $('#wizard_verticle').smartWizard({
                transitionEffect: 'slide',
                labelNext:'Siguiente',
                labelPrevious:'Anterior',
                labelFinish:'Guardar',
            });
            $('.buttonFinish').addClass('btn btn-info');
            $('.buttonNext').addClass('btn btn-success');
            $('.buttonPrevious').addClass('btn btn-success');
            paginador('mydatatable');

        });
        function sele(value){
            if(value=="Unidad Mayor"){
                $('#oficina_id').attr('disabled',true);
                document.getElementById('mensaje').innerHTML="Seleccione Direccion";
            }else{
                $('#oficina_id').attr('disabled',false);
                document.getElementById('mensaje').innerHTML=" "
            }
        }
        function eliminar(id){
            var a=confirm("esta sergiro eliminar esta Oficina?");
            if(a==true)
            {
                $.ajax({
                    url:'{{url('deleteunidad')}}',
                    type:'get',
                    data:{id:id},
                    success:function(data){
                        setTimeout("location.reload()",1000);
                    }
                });
            }
        }
    </script>
@endsection