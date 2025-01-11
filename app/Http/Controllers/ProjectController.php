<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Lib\Datatable;
use App\Lib\Utils;
use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function projects(Request $request) {
        return view("pages.projects");
    }

    public function create(ProjectRequest $request) {
        $validated = $request->validated();

        $users = $validated["users"] ?? [];
        unset($validated['users']);

        DB::beginTransaction();
        $project = Projects::create($validated);
        if ($users) {
            $project->users()->attach($users);
        }
        DB::commit();
        
        $this->result['status'] = 'success';
        return response()->json($this->result);
    }

    public function read(ProjectRequest $request) {
        $validated = $request->validated();

        $project = Projects::with("users")->find($validated['id']);

        $this->result['status'] = "success";
        $this->result['data'] = $project;
        return response()->json($this->result);
    }

    public function update(ProjectRequest $request) {
        $validated = $request->validated();
        
        $project = Projects::with("users")->find($validated['id']);
        
        $users = $validated["users"] ?? [];
        unset($validated['users'], $validated['id']);

        $db_users = Utils::array_str_to_int($project->users->pluck("id")->toArray());

        DB::beginTransaction();
        $project->update($validated);
        if (!Utils::array_equals($users, $db_users)) {
            $project->users()->detach();
            $project->users()->attach($users);
        }
        DB::commit();
     
        $this->result['status'] = "success";
        return response()->json($this->result);
    }

    public function delete(ProjectRequest $request) {
        $validated = $request->validated();

        $project = Projects::find($validated['id']);
        $project->delete();

        $this->result['status'] = "success";
        return response()->json($this->result);
    }

    public function datatable(Request $request) {
        $dt = new Datatable($request);

        $dt->query = Projects::query()->withCount(["users"]);
        $dt->count()->order()->paginate()->result();

        $this->result['data'] = $dt->data;
        $this->result['iTotalDisplayRecords'] = $dt->count;
        $this->result['iTotalRecords'] = $dt->count;
        $this->result['sql'] = $dt->sql();
        return $this->result;
    }
}
