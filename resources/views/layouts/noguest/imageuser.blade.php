<div class="user-panel">
    <div class="pull-left image">
                {!! Html::image('image/img1.png',null,["class"=>"img-circle"]) !!}

    </div>
    <div class="pull-left info">
        <p>{{Auth::user()->name}}</p>
        <?php $unidad=App\Oficina::find(Auth::user()->oficina_id)?>
        <p>{{$unidad->name}}</p>
        
    </div>
</div>