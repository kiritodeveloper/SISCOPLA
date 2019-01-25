@extends('layouts.dashboard')

@section('title')
    Login

@endsection

@section('style')
    @parent

@endsection

@section('pager-title')
    Iniciar Sesión
@endsection

@section('description')
    Login
@endsection

@section('content')
    <div id="page-wrapper">

        <div class="row ">
            <div class="col-lg-3 text-center v-center">
            </div>
            <div class="col-lg-6 text-center v-center">             

                <br>
                <img src="image/login.png" width="180px" height="200px">
                <br>

                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Uups!</strong> hubo un problema al entrar a su cuenta<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>

                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('login') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <p class="lead">Ingrese sus datos</p>
                        <div class="form-group ">
                            <label class="col-md-4 control-label">Nombre de Usuario</label>
                            <div class="col-md-6">
                                {!! Form::text('username',null,['class'=>'form-control','placeholder'=>'Juan_Peres12','required']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Contrase&ntildea</label>
                            <div class="col-md-6">
                                {!! Form::password('password',['class'=>'form-control','placeholder'=>'*********',"required"]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" id="login">Ingresar</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>


        <!-- /.row -->

    </div>

@endsection

@section('script')
    @parent
@endsection