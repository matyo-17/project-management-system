<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Lib\Datatable;
use App\Lib\Utils;
use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function projects(Request $request) {
        return view("pages.projects");
    }

    public function project_info(ProjectRequest $request, int $id) {
        $validated = $request->validated();

        $project = Projects::with(["users", "invoices", "expenses"])
                            ->find($validated['id']);

        $this->result['project'] = $project;
        return view("pages.project-info", $this->result);
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

    public function read(ProjectRequest $request, int $id) {
        $validated = $request->validated();

        $project = Projects::with("users")->find($id);

        $this->result['status'] = "success";
        $this->result['data'] = $project;
        return response()->json($this->result);
    }

    public function update(ProjectRequest $request, int $id) {
        $validated = $request->validated();
        
        $project = Projects::with("users")->find($id);
        
        $users = $validated["users"] ?? [];
        unset($validated['users']);

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

    public function delete(ProjectRequest $request, int $id) {
        $validated = $request->validated();

        $project = Projects::find($id);
        $project->delete();

        $this->result['status'] = "success";
        return response()->json($this->result);
    }

    public function datatable(Request $request) {
        $user = Context::get("user");

        $dt = new Datatable($request);

        $dt->query = Projects::query()
                                ->with(["users", "expenses"])
                                ->withSum(["expenses" => function($q) {
                                    $q->where("status", "approved");
                                }], "amount");
                                
        if (!$user->is_admin()) {
            $dt->query->whereHas("users", function ($q) use ($user) {
                $q->where("id", $user->id);
            });
        }

        $filters = $dt->filters;
        if ($filters["title"] ?? null) {
            $dt->query->where("title", $filters['title']);
        }
        
        if ($filters['status'] ?? []) {
            $dt->query->whereIn('status', $filters['status']);
        }
        
        $dt->count()->order()->paginate()->result();

        $this->result['data'] = $dt->data;
        $this->result['iTotalDisplayRecords'] = $dt->count;
        $this->result['iTotalRecords'] = $dt->count;
        return $this->result;
    }
}
