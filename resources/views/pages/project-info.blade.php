@extends("layouts.main")

@section("title", "Project Info")

@section("content")
<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $project->title }}</h5>
        <p class="card-text">{{ $project->description }}</p>

        <div class="row mb-2">
            <div class="col-12 col-md-4 fw-bold">Start Date</div>
            <div class="col-12 col-md-8">{{ $project->start_date }}</div>
        </div>

        <div class="row mb-2">
            <div class="col-12 col-md-4 fw-bold">End Date</div>
            <div class="col-12 col-md-8">{{ $project->end_date }}</div>
        </div>

        <div class="row mb-2">
            <div class="col-12 col-md-4 fw-bold">Budget</div>
            <div class="col-12 col-md-8">RM {{ $project->budget }}</div>
        </div>

        <div class="row mb-2">
            <div class="col-12 col-md-4 fw-bold">Status</div>
            <div class="col-12 col-md-8">{{ $project->status }}</div>
        </div>

        <div class="row mb-2">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="text-center table-dark">
                        <tr>
                            <th>Users</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($project->users as $u)
                        <tr>
                            <td class="text-center">{{ $u->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section("scripts")
@endsection