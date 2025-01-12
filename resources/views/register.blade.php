@extends("layouts.auth")

@section("content")
<h4 class="card-title text-center mb-2">
    {{ config('app.name') }}
</h4>

<form method="POST" action="{{ route('sign-up') }}">
    @csrf
    <div class="mb-2">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" autofocus required/>
    </div>

    <div class="mb-2">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" required/>
    </div>

    <div class="mb-2">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required/>
    </div>

    <div class="mb-2">
        <label class="form-label" for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" required/>
    </div>

    <div class="mb-2">
        <label class="form-label" for="confirm-password">Confirm Password</label>
        <input type="password" class="form-control" id="confirm-password" name="password_confirmation" required/>
    </div>

    @if ($errors->any())
    <div class="mb-2">
        <div class="alert alert-danger" role="alert">
            <div class="alert-body">{{ $errors->first() }}</div>
        </div>
    </div>
    @endif

    <button class="btn btn-primary w-100" type="submit">Register</button>

    <div class="my-1 text-center">
        Already have an account?
        <a href="{{ route('login') }}">Sign in instead</a>
    </div>
</form>
@endsection