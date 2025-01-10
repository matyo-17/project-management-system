<nav class="navbar navbar-expand-md bg-primary sticky-top" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
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
                        <a class="nav-link px-2 {{ $route == $m['route'] ? 'active' : '' }}" href="{{ route($m['route']) }}">
                            <i class="{{ $m['icon'] }}"></i> &nbsp; {{ $m['name'] }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </nav>