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

                {!! Form::model($user,['route'=>['user.update',$user->id], 'role' => 'form', 'method' => 'put']) !!}
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
                        El Usuario pertenece a una:
                        <table class="table table-bordered">
                            <tr>
                                <td><label>Unidad Mayor </label></td>
                                <td>@if($launidad->type=="Unidad Mayor")
                                        <input type="radio" class="flat" name="type"  value="Unidad Mayor" onclick="sele(this.value)" checked/>
                                    @else
                                        <input type="radio" class="flat" name="type"  value="Unidad Mayor" onclick="sele(this.value)"/>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><label>Unidad Dependiente </label></td>
                                <td>@if($launidad->type=="Unidad Dependiente")
                                        <input type="radio" class="flat" name="type"  value="Unidad Dependiente" onclick="sele(this.value)" checked/>
                                    @else
                                        <input type="radio" class="flat" name="type"  value="Unidad Dependiente" onclick="sele(this.value)"/>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><label>Facultad </label></td>
                                <td>
                                    @if($launidad->type=="Facultad")
                                        <input type="radio" class="flat" name="type"  value="Facultad" onclick="sele(this.value)" checked/>
                                    @else
                                        <input type="radio" class="flat" name="type"  value="Facultad" onclick="sele(this.value)"/>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><label>Carrera </label></td>
                                <td>
                                    @if($launidad->type=="Carrera")
                                        <input type="radio" class="flat" name="type"  value="Carrera" onclick="sele(this.value)" checked/>
                                    @else
                                        <input type="radio" class="flat" name="type"  value="Carrera" onclick="sele(this.value)"/>
                                    @endif
                                </td>
                            </tr>

                        </table>

                    </div>
                    <div id="step-22">
                        <h2 class="StepTitle" id="especifique">Especifique</h2>
                        <label class="mensaje" id="mensaje"></label>

                        <table  class="table table-bordered table-striped">
                            <table  class="table table-bordered table-striped">
                                <tr>
                                    <td>Unidad Mayor</td>
                                    <td>
                                        <select name="unidad_mayor" id="unidad_mayor" class="form-control" onchange="cambio(this.value,'unidad')">
                                            <option value="">Seleccione</option>
                                            @foreach($unidads as $u)
                                                @if($launidad->oficina_id==$u->id)
                                                    <option selected value="{{$u->id}}">{{$u->name}}</option>
                                                @else
                                                    <option value="{{$u->id}}">{{$u->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Unidad Dependiente</td>
                                    <td>

                                        <select name="unidad_dependiente" id="unidad_dependiente" class="form-control" >
                                            @if($launidad->type=="Unidad Dependiente")
                                                <option value="{{$launidad->id}}" >{{$launidad->name}}</option>
                                            @else
                                                <option value="" >Seleccione</option>
                                            @endif
                                        </select>

                                    </td>
                                </tr>
                                <tr>
                                    <td>Facultad</td>
                                    <td>
                                        <select name="facultad" id="facultad" class="form-control" onchange="cambio(this.value,'facultad')">
                                            <option value="">Seleccione</option>
                                            @foreach($facultads as $u)
                                                @if($launidad->oficina_id==$u->id)
                                                    <option selected value="{{$u->id}}">{{$u->name}}</option>
                                                @else
                                                    <option value="{{$u->id}}">{{$u->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Carrera</td>
                                    <td>
                                        <select name="carrera" id="carrera" class="form-control" >
                                            @if($launidad->type=="Carrera")
                                                <option value="{{$launidad->id}}" >{{$launidad->name}}</option>
                                            @else
                                                <option value="" >Seleccione</option>
                                            @endif
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </table>
                    </div>
                    <div id="step-33">
                        <h3 class="StepTitle" >Nombre de la Oficina</h3>

                        <br>
                        <br>
                        <table class="table table-responsive">
                            <tr>
                                <td>{!! Form::label('name','Nombre') !!}</td>
                                <td>{!! Form::text('name',null,["class"=>"form-control","placeholder"=>"Nombre",'required']) !!}</td>
                            </tr>
                            <tr>
                                <td>{!! Form::label('last_name','Apellido') !!}</td>
                                <td>{!! Form::text('last_name',null,["class"=>"form-control","placeholder"=>"Apellidos",'required']) !!}</td>
                            </tr>
                            <tr>
                                <td>{!! Form::label('email','Correo Electronico') !!}</td>
                                <td>{!! Form::email('email',null,["class"=>"form-control","placeholder"=>"Email",'required']) !!}</td>
                            </tr>
                            <tr>
                                <td>{!! Form::label('celular','Celular') !!}</td>
                                <td>{!! Form::text('celular',null,["class"=>"form-control","placeholder"=>"Nro. Celular",'required']) !!}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                {!! Form::close() !!}


        </div>
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
        });
    </script>

    <script>


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

    </script>
@endsection