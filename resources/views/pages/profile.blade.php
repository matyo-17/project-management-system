@extends('layouts.main')

@section("title", "Roles")

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="modal-content" id="form-profile" action="javascript:save()">
                    <div class="row row-cols-1 row-cols-md-3">
                        <div class="col mb-2">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" class="form-control" name="username" value="{{ $user->username }}" disabled>
                        </div>
                        <div class="col mb-2">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" class="form-control" name="name" value="{{ $user->name }}" required>
                        </div>
                        <div class="col mb-2">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" id="email" class="form-control" name="email" value="{{ $user->email }}" required>
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2">
                        <div class="col mb-2">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" class="form-control" name="password">
                        </div>
                        <div class="col mb-2">
                            <label for="confirm-password" class="form-label">Confirm Password</label>
                            <input type="password" id="confirm-password" class="form-control" name="password_confirmation">
                        </div>
                    </div>

                    @if ($errors->any())
                    <div class="mb-1">
                        <div class="alert alert-danger" role="alert">
                            <div class="alert-body">{{ $errors->first() }}</div>
                        </div>
                    </div>
                    @endif

                    <div class="row text-center">
                        <div class="col">
                            <button class="btn btn-outline-danger" type="reset">Cancel</button>
                            <button class="btn btn-success" type="submit">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var urlCrud = "/api/profile";
    
    function save() {
        var formData = formToObject("form-profile");
        if (formData.password !== formData.password_confirmation) {
            toast("danger", "Passwords do not match");
            return;
        }

        actionBtn = $("button[type=submit], button[type=reset]");
        actionBtn.prop("disabled", true);

        $.ajax({
            url: urlCrud,
            data: formData,
            type: 'patch',
            success: function(res) {
                toastMessage = (formData.password) ? "Please log in again..." : 'Page will reload in a few seconds...';
                toast('success', 'Success', toastMessage);
                setTimeout(function () { location.reload(); }, 500);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                toast('danger', 'Failed to update profile', xhr.responseJSON.error);
                actionBtn.prop("disabled", false);
            }
        });
    }
</script>
@endsection