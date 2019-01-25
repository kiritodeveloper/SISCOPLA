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
                    <h2>NUEVO ROL</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="panel" align="center">
                        {!! Form::open(['route'=>'roles.store', 'role' => 'form', 'method' => 'post']) !!}
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
                            </ul>
                            <div id="step-11">
                                <p class="alert alert-info">
                                    Datos de Rol
                                </p>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><label>Nombre Corto: </label></td>
                                        <td><input type="text" class="form-control" name="name" id="name" maxlength="100" required/></td>
                                    </tr>
                                    <tr>
                                        <td><label>Nombre Para Mostrar: </label></td>
                                        <td><input type="text" class="form-control" name="display_name" id="display_name" maxlength="110" required/></td>
                                    </tr>
                                    <tr>
                                        <td><label>Descripcion : </label></td>
                                        <td><input type="text" class="form-control" name="description" id="description" maxlength="220" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div id="step-22">
                                <h2 class="StepTitle" id="especifique">Especifique</h2>
                                <div class="myscroll">
                                    <table class="table">
                                        @foreach($permissions as $per)
                                            <tr>
                                                <td>{{$per->display_name}}</td>
                                                <td>{{$per->description}}</td>
                                                <td><input type="checkbox" name="lista[]" value="{{$per->id}}"></td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
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
    {!! Html::script('assets/wizard/jquery.smartWizard.js') !!}
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
        });
        $(document).on('keydown','#name',function(e){
            if(!(/^[A-Za-z\ñ\Ñ\ ]+$/.test(e.key))){
                e.preventDefault();
            }
        });
        $(document).on('keydown','#display_name',function(e){
            if(!(/^[A-Za-z\ñ\Ñ\ ]+$/.test(e.key))){
                e.preventDefault();
            }
        });
    </script>
@endsection