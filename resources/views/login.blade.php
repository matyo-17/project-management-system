@extends("layouts.auth")

@section("content")
<h4 class="card-title text-center mb-2">
    {{ config('app.name') }}
</h4>

<form method="POST" action="{{ route('authenticate') }}">
    @csrf
    <div class="mb-2">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" autofocus required/>
    </div>

    <div class="mb-2">
        <div class="d-flex">
            <label class="form-label" for="password">Password</label>
        </div>
        <div class="input-group input-group-merge">
            <input type="password" class="form-control" id="password" name="password"required/>
        </div>
    </div>

    @if ($errors->any())
    <div class="mb-2">
        <div class="alert alert-danger" role="alert">
            <div class="alert-body">{{ $errors->first() }}</div>
        </div>
    </div>
    @endif

    <button class="btn btn-primary w-100" type="submit">Login</button>

    <div class="my-1 text-center">
        New on our platform?
        <a href="{{ route('register') }}">Create an account</a>
    </div>
</form>
@endsection