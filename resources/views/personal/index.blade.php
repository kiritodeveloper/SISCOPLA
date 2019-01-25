@extends('layouts.dashboard')

@section('title')
    Incio
@endsection

@section('style')
    @parent
    {!! Html::style('assets/build/custom/css/mycustom.css') !!}
@endsection

@section('pager-title')
    Revision
@endsection

@section('description')
    Personal
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <table id="mytable" class="table table-bordered table-responsive table-striped">
                <thead>
                <tr  style="background: #122b40; color:#fff">
                    <td>Unidad</td>
                    <td>Usuario</td>
                    <td>Celular</td>
                    <td>Email</td>
                    <td>Rol</td>
                    <td>Opciones</td>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $u)
                    <tr>
                        <td>{{$u->unidad->name}}</td>
                        <td>{{$u->name}} {{$u->last_name}}</td>
                        <td>{{$u->celular}}</td>
                        <td>{{$u->email}}</td>
                        <td>{{$u->rol}}</td>
                        <td><a href="{{url('revisar/'.Crypt::encrypt($u->id))}}" class="btn btn-success"><i class="fa fa-eye"></i>Ver planillas</a> </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection

@section('script')
    @parent
    <script>
        $(document).ready(function(){
            paginador('mytable');
        });
    </script>

@endsection