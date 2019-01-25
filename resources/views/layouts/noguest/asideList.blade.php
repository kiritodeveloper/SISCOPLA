<ul class="sidebar-menu">
    <li class="header">Menu</li>
    @permission(('admin-role'))
        <li class="treeview">
            <a href="{{url('roles')}}"><i class="fa fa-reddit"></i> <span> Roles de Usuario</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
            </a>
        </li>
    @endpermission
    @permission(('admin-direccion'))
        <li class="treeview">
            <a href="{{url('unidad')}}"><i class="fa fa-reddit"></i> <span> Administrar Direccion</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
        </li>
    @endpermission
    @permission(('admin-facultades'))
        <li class="treeview">
            <a href="{{url('facultad')}}"><i class="fa fa-reddit"></i> <span>Administrar Facultades</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
        </li>
    @endpermission
    @permission(('admin-users'))
        <li class="treeview">
            <a href="{{url('user')}}"><i class="fa fa-reddit"></i> <span>Administrar Usuarios</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
        </li>
    @endpermission
    @permission(('planillas'))
        <li class="treeview">
            <a href="#"><i class="fa fa-folder "></i> Planillas
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="{{url('planilla')}}"><i class="fa fa-upload"></i> Enviar a revision
                    <span class="pull-right-container">
                      <i class="fa fa-angle-right pull-right"></i>
                    </span>
                    </a>
                </li>
                <li>
                    <a href="{{url('verplanilla')}}"><i class="fa fa-eye"></i> Ver Planillas
                    <span class="pull-right-container">
                      <i class="fa fa-angle-right pull-right"></i>
                    </span>
                    </a>
                </li>
            </ul>
        </li>
    @endpermission
    @permission(('documentos'))
        <li class="treeview">
            <a href="#"><i class="fa fa-folder "></i> Documentos Extras
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="{{url('archi')}}"><i class="fa fa-upload"></i> Agregar al sistema
                    <span class="pull-right-container">
                      <i class="fa fa-angle-right pull-right"></i>
                    </span>
                    </a>
                </li>
                <li>
                    <a href="{{url('verdocumento')}}"><i class="fa fa-eye"></i> Ver Documentos
                    <span class="pull-right-container">
                      <i class="fa fa-angle-right pull-right"></i>
                    </span>
                    </a>
                </li>
            </ul>
        </li>
    @endpermission
    @permission(('mensajeria'))
        <li class="treeview">
            <a href="{{url('mensajes')}}"><i class="fa fa-reddit"></i> <span>Mensajeria</span>
            <span class="pull-right-container">
                @if(count(Auth::user()->MEEt())>0)
                    <span class="label label-primary pull-right">
                        @if(count(Auth::user()->MEEt())==1)
                            un nuevo
                        @else
                            {{count(Auth::user()->MEEt())}} Nuevos
                        @endif
                    </span>
                @else
                    <i class="fa fa-angle-right pull-right"></i>
                @endif
            </span>
            </a>
        </li>
    @endpermission
    @permission(('ayuda'))
        <li class="treeview">
            <a href="{{url('help')}}"><i class="fa fa-info"></i> <span>Ayuda</span>
            <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
            </span>
            </a>
        </li>
    @endpermission
    @permission(('revision'))
        <li class="treeview">
            <a href="{{url('revisar')}}"><i class="fa fa-file"></i> <span>Revisar Documentos</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-right pull-right"></i>
            </span>
            </a>
        </li>
    @endpermission
</ul>



