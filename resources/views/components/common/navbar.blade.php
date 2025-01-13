<nav class="navbar navbar-expand-md bg-primary sticky-top mb-3" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <img src="{{ asset('favicon.ico') }}" alt="logo" width="30" height="30" class="d-inline-block align-text-top rounded-5">
            <span class="h5">{{ config('app.name') }}</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbar-offcanvas" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="offcanvas offcanvas-end flex-grow-1 bg-primary" id="navbar-offcanvas">
            <div class="offcanvas-header">
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <span class="h5">{{ config('app.name') }}</span>
                </a>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <hr class="d-md-none m-0">
            <div class="offcanvas-body">
                <div class="navbar-nav me-auto">
                    @foreach ($menu as $m)
                        @if (!isset($m['submenu']))
                        <li class="nav-item">
                            <a class="nav-link {{ $route == $m['route'] ? 'active' : '' }}" href="{{ route($m['route']) }}">
                                {{ $m['name'] }}
                            </a>
                        </li>
                        @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $m['name'] }}
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($m['submenu'] as $s)
                                <li>
                                    <a class="dropdown-item" href="{{ route($s['route']) }}">{{ $s['name'] }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        @endif
                    @endforeach
                </div>

                <hr>
                
                <div class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="{{ route('logout') }}" type="button">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span class="d-md-none">&nbsp;Logout</span>
                        </a>
                    </li>
                </div>
            </div>
        </div>
    </div>
</nav>