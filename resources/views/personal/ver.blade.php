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
    Inicio
@endsection

@section('description')
    Universidad
@endsection

@section('content')
    <div id="main_area">
        <div class="row">
        <div class="col-xs-12">
        <?php $user=\App\User::with('unidad')->find(Crypt::decrypt($id));?>
        <h3>Nombre de Usuario: {{$user->name}} {{$user->last_name}}</h3>
        <h3>{{$user->unidad->name}}</h3>
        </div>
            <div class="col-xs-12" id="slider">
                @if(count($planillas)>0)
                    <div class="row">
                        <div class="col-sm-8" id="carousel-bounding-box">
                            <div class="carousel slide" id="myCarousel">
                                <div class="carousel-inner">
                                    @for($i=0;$i<count($planillas);$i++)
                                        @if($i==0)
                                            <div class="active item" data-slide-number="{{$i}}">
                                                <a href="{{url($planillas[$i]->image)}}" target="_blank">{!! Html::image($planillas[$i]->image) !!}</a>
                                            </div>
                                        @else
                                            <div class="item" data-slide-number="{{$planillas[$i]->id}}">
                                                <a href="{{url($planillas[$i]->image)}}" target="_blank">{!! Html::image($planillas[$i]->image) !!}</a>
                                            </div>
                                        @endif
                                    @endfor
                                </div>
                                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                </a>
                                <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                </a>
                            </div>
                        </div>

                        <div class="col-sm-4" id="carousel-text"></div>

                    <div id="slide-content" style="display: none;">
                        @for($i=0;$i<count($planillas);$i++)
                        <div id="slide-content-{{$i}}">
                            @if($planillas[$i]->shift=="m")
                            <h2>Turno Ma&ntilde;ana</h2>
                            @else
                                @if($planillas[$i]->shift=="n")
                                    <h2>Turno Noche</h2>
                                @else
                                    <h2>Turno Tarde</h2>
                                @endif
                            @endif
                           <h2> <p>{{$planillas[$i]->observacion}}</p></h2>
                           <h2> <p class="sub-text">{{$planillas[$i]->date}}</p></h2>
                        </div>
                        @endfor
                    </div>

                    </div>
                @else
                    <h3 class="alert alert-danger">No hay archivos disponibles</h3>
                @endif
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
        {!! Form::open(['url'=>'revisar/'.$id,'method'=>'get','role'=>'form']) !!}
                <table class="table" width="100%">
                    <tr>
                        <td width="18%">Inicio</td>
                        <td width="18%"><input type="date" name="inicio" class="form-control" value="{{$inicio}}"></td>
                        <td width="18%">Fin</td>
                        <td width="18%"><input type="date" name="fin" class="form-control" value="{{$fin}}"></td>
                        <td width="18%">Nombre</td>
                        <td width="18%"><input type="text" name="nombre" value="{{$nombre}}"></td>
                        <td><button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Buscar</button></td>
                    </tr>
                </table>
        {!! Form::close() !!}  
            </div>
        </div>

        <br>
        @if(count($planillas)>0)
        <div class="wrapper2">
            <div class="scrolls2">

                    @for($i=0;$i<count($planillas);$i++)
                        <a id="carousel-selector-{{$i}}" >
                            {!! Html::image($planillas[$i]->minimagen,null,['style'=>'border: 3px solid green','width'=>'200px','height'=>"110px"]) !!}</a>
                    @endfor
            </div>
        </div>
         @endif
    </div>
@endsection

@section('script')
    @parent


    <script>
        jQuery(document).ready(function($) {
            $('#myCarousel').carousel({
                interval: 500000
            });
            $('#carousel-text').html($('#slide-content-0').html());
            $('[id^=carousel-selector-]').click( function(){
                var id = this.id.substr(this.id.lastIndexOf("-") + 1);
                var id = parseInt(id);
                $('#myCarousel').carousel(id);
            });
            $('#myCarousel').on('slid.bs.carousel', function (e) {
                var id = $('.item.active').data('slide-number');
                $('#carousel-text').html($('#slide-content-'+id).html());
            });
        });
    </script>



@endsection