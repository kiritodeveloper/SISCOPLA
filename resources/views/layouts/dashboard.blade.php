<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <title>Mensajeria - @yield('title')</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @section('style')
    @parent


        {!! Html::style('assets/bootstrap/css/bootstrap.min.css') !!}
        {!! Html::style('assets/internet/css/font-awesome.min.css') !!}
        {!! Html::style('assets/internet/css/ionicons.min.css') !!}
        {!! Html::style('assets/dist/css/AdminLTE.min.css') !!}
        {!! Html::style('assets/dist/css/skins/skin-blue.min.css') !!}

        {!! Html::style('assets/plugins/datatables/dataTables.bootstrap.css') !!}

        {!! Html::style('assets/plugins/pnotify/dist/pnotify.css') !!}
        {!! Html::style('assets/plugins/pnotify/dist/pnotify.buttons.css') !!}
        {!! Html::style('assets/plugins/pnotify/dist/pnotify.nonblock.css') !!}
    @show
</head>

<body class="hold-transition skin-blue sidebar-mini">


<div class="wrapper">


    @include('layouts.header')

    @include('layouts.aside')

    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                
                @yield('pager-title')
               
            </h1>
        </section>
        <section class="content">
            @yield('content')
        </section>
    </div>
    @include('layouts.footer')
    @if(!(Auth::guest()))
        @include('layouts.asideLeft')
    @endif
</div>
@section('script')
    @parent

    {!! Html::script('assets/plugins/jQuery/jquery-2.2.3.min.js') !!}
    {!! Html::script('assets/bootstrap/js/bootstrap.min.js') !!}
    {!! Html::script('assets/dist/js/app.min.js') !!}

    {!! Html::script('assets/plugins/datatables/jquery.dataTables.min.js') !!}
    {!! Html::script('assets/plugins/datatables/dataTables.bootstrap.min.js') !!}
    {!! Html::script('assets/myscript.js') !!}
    {!! Html::script('assets/plugins/pnotify/dist/pnotify.js') !!}
    
    {!! Html::script('assets/plugins/pnotify/dist/pnotify.nonblock.js') !!}
    @include('layouts.crud')
@show
</body>
</html>
