<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Lib\Datatable;
use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function role(Request $request) {
        $this->result['permissions'] = Permissions::all();
        return view("pages.roles", $this->result);
    }

    public function create(RoleRequest $request) {
        $validated = $request->validated();

        $permissions = $validated["permissions"] ?? [];
        unset($validated["permissions"]);

        DB::beginTransaction();
        $role = Roles::create($validated);
        $role->permissions()->attach($permissions);
        DB::commit();

        $this->result['status'] = 'success';
        return response()->json($this->result);
    }

    public function update(RoleRequest $request, int $id) {
        $validated = $request->validated();

        $permissions = $validated["permissions"] ?? [];
        unset($validated["id"], $validated["permissions"]);
        
        $role = Roles::find($id);

        DB::beginTransaction();
        $role->update($validated);
        $role->permissions()->detach();
        $role->permissions()->attach($permissions);
        DB::commit();

        $this->result['status'] = 'success';
        return response()->json($this->result);
    }

    public function read(RoleRequest $request, int $id) {
        $validated = $request->validated();

        $role = Roles::with("permissions")->find($id);

        $this->result['status'] = "success";
        $this->result['data'] = $role;
        return response()->json($this->result);
    }

    public function delete(RoleRequest $request, int $id) {
        $validated = $request->validated();

        $role = Roles::find($id);
        $role->delete();

        $this->result['status'] = "success";
        return response()->json($this->result);
    }

    public function datatable(Request $request) {
        $dt = new Datatable($request);

        $dt->query = Roles::query();
        $dt->count()->order()->paginate()->result();

        $this->result['data'] = $dt->data;
        $this->result['iTotalDisplayRecords'] = $dt->count;
        $this->result['iTotalRecords'] = $dt->count;
        return $this->result;
    }
}
