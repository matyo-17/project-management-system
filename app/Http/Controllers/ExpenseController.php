<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Http\Requests\ExpenseStatusRequest;
use App\Models\Expenses;
use Illuminate\Http\Request;

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
}
