
<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        {!! Html::image('image/user.png',null,["class"=>"user-image",'alt'=>'User Image']) !!}
        <span class="hidden-xs">{{Auth::user()->name}}</span>
    </a>
    <ul class="dropdown-menu">
        <li class="user-header">
            {!! Html::image('image/user.png',null,["class"=>"img-circle",'alt'=>'User Image']) !!}
            <p>
                {{Auth::user()->name}}
                <br>
                {{Auth::user()->rol}}
                <small>{{Auth::user()->email}}</small>
            </p>
        </li>
        <li class="user-footer">
            <div class="pull-right">
                <a href="{{URL('/logout')}}" class="btn btn-success" id="logout">Salir</a>
            </div>
        </li>
    </ul>
</li>
@if(Auth::user()->rol=="Administrador")
<li>
    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
</li>

@endif