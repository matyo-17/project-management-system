<?php

namespace App\Http\Controllers;

use App\Lib\Datatable;
use App\Models\Projects;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function projects(Request $request) {
        return view("pages.projects");
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
