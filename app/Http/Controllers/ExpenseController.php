<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Http\Requests\ExpenseStatusRequest;
use App\Lib\Datatable;
use App\Models\Expenses;
use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;

class ExpenseController extends Controller
{
    public function expenses(Request $request) {
        return view("pages.expenses");
    }

    public function expense_info(Request $request) {
        return view("pages.expenses");
    }

    public function create(ExpenseRequest $request) {
        $validated = $request->validated();

        $project = Projects::find($validated['project_id']);
        $total = $project->total_expense_amount(true);
        
        if (($total + $validated['amount']) > $project->budget) {
            $this->result['error'] = "Budget exceeded.";
            return response()->json($this->result, 400);
        }

        $expense = Expenses::create($validated);

        $this->result['status'] = 'success';
        return response()->json($this->result);
    }

    public function read(ExpenseRequest $request, int $id) {
        $validated = $request->validated();

        $expense = Expenses::find($id);

        $this->result['status'] = "success";
        $this->result['data'] = $expense;
        return response()->json($this->result);
    }

    public function update(ExpenseRequest $request, int $id) {
        $validated = $request->validated();
        
        $expense = Expenses::find($id);
        $expense->update($validated);
     
        $this->result['status'] = "success";
        return response()->json($this->result);
    }

    public function delete(ExpenseRequest $request, int $id) {
        $validated = $request->validated();

        $expense = Expenses::find($id);
        $expense->delete();

        $this->result['status'] = "success";
        return response()->json($this->result);
    }

    public function status(ExpenseStatusRequest $request, int $id) {
        $validated = $request->validated();

        $expense = Expenses::find($id);
        $expense->update($validated);
        
        $this->result['status'] = "success";
        return response()->json($this->result);
    }

    public function datatable(Request $request) {
        $user = Context::get("user");
        
        $dt = new Datatable($request);

        $dt->query = Expenses::query()->with(["project", "project.users"]);

        if (!$user->is_admin()) {
            $dt->query->whereHas("project.users", function ($q) use ($user) {
                $q->where("id", $user->id);
            });
        }

        $dt->count()->order()->paginate()->result();

        $this->result['data'] = $dt->data;
        $this->result['iTotalDisplayRecords'] = $dt->count;
        $this->result['iTotalRecords'] = $dt->count;
        return $this->result;
    }
}
