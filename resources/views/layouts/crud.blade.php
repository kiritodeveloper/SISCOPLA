<script>
    var mm='';

    @if(count($errors)>0)
            @foreach ($errors->all() as $error)
            mm+='{{ $error }}'+'\n';
    @endforeach
        new PNotify({
        title: 'Oh No!!! ERROR de registro',
        text: mm,
        type: 'error',
        styling: 'bootstrap3',
        hide: true,
    });
    @endif

    @if(Session::has('save'))
        new PNotify({
        title: 'Registro Correcto',
        text: '{{Session::get('save')}}',
        type: 'success',
        styling: 'bootstrap3',
        hide: true,
    });
    @endif

    @if(Session::has('edit'))
    new PNotify({
        title: 'Registro Editado Correctamente',
        text: '{{Session::get('edit')}}',
        type: 'success',
        styling: 'bootstrap3',
        hide: true,
    });
    @endif
    @if(Session::has('delete'))
        new PNotify({
        title: 'Registro Eliminado',
        text: '{{Session::get('delete')}}',
        type: 'warning',
        styling: 'bootstrap3',
        hide: true,
    });
    @endif
    @if(Session::has('noticie'))
        new PNotify({
        title: 'Noticia',
        text: '{{Session::get('noticie')}}',
        type: 'info',
        styling: 'bootstrap3',
        hide: true,
    });
    @endif
    @if(Session::has('error'))
        new PNotify({
        title: 'Error!!!',
        text: '{{Session::get('error')}}',
        type: 'error',
        styling: 'bootstrap3',
        hide: true,
    });
    @endif

</script>