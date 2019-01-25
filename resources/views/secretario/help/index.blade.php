@extends('layouts.dashboard')

@section('title')
    Incio
@endsection

@section('style')
    @parent




    <style>
        .hide-bullets {
            list-style:none;
            margin-left: -40px;
            margin-top:20px;
        }
    </style>

    <style type="text/css">

        .wrapper2 {
            background:#EFEFEF;
            box-shadow: 1px 1px 10px #999;
            margin: auto;
            text-align: center;
            position: relative;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            margin-bottom: 20px !important;
            width: 100%;
            padding-top: 5px;
        }
        .scrolls2 {
            overflow-x: scroll;
            overflow-y: hidden;
            height: 130px;
            white-space:nowrap
        }
    </style>

@endsection

@section('pager-title')
    Ayuda al Personal de Secretari@
@endsection

@section('description')
    Universidad
@endsection

@section('content')
    <div id="main_area">
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel panel-heading panel-success">
                        Video de Ayuda
                    </div>
                    <div class="panel panel-body">
                        <video width="720" height="540" controls>
                            <source src="{{url('/componente/video.mp4')}}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @parent

@endsection