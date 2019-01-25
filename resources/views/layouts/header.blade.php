<header class="main-header">
    <a href="#" class="logo">
        <span class="logo-mini"><b>S</b>M</span>
        <span class="logo-lg"><b>Sistema</b>Mensajeria</span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        @if(!(Auth::guest()))
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

        @endif
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                @if(!Auth::guest())
                    @include('layouts.noguest.header')
                @endif
            </ul>
        </div>
    </nav>
</header>
    