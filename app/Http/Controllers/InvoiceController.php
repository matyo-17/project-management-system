<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Http\Requests\InvoiceStatusRequest;
use App\Lib\Datatable;
use App\Lib\General;
use App\Models\Invoices;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function invoices(Request $request) {
        return view("pages.invoices");
    }

    public function invoice_info(Request $request) {
        return abort(503);
    }

    public function create(InvoiceRequest $request) {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            $validated['inv_no'] = General::generate_invoice_number();
            $invoice = Invoices::create($validated);
        } catch (Exception $e) {
            DB::rollBack();
            $this->result["error"] = $e->getMessage();
            return response()->json($this->result, 500);
        }
        DB::commit();

        $this->result['status'] = 'success';
        return response()->json($this->result);
    }

    public function read(InvoiceRequest $request, int $id) {
        $validated = $request->validated();

        $invoice = Invoices::find($id);

        $this->result['status'] = "success";
        $this->result['data'] = $invoice;
        return response()->json($this->result);
    }

    public function update(InvoiceRequest $request, int $id) {
        $validated = $request->validated();
        
        $invoice = Invoices::find($id);
        $invoice->update($validated);
     
        $this->result['status'] = "success";
        return response()->json($this->result);
    }

    public function delete(InvoiceRequest $request, int $id) {
        $validated = $request->validated();

        $invoice = Invoices::find($id);
        $invoice->delete();

        $this->result['status'] = "success";
        return response()->json($this->result);
    }

    public function status(InvoiceStatusRequest $request, int $id) {
        $validated = $request->validated();

        $invoice = Invoices::find($id);
        $invoice->update($validated);
        
        $this->result['status'] = "success";
        return response()->json($this->result);
    }

    public function datatable(Request $request) {
        $user = Context::get("user");
        
        $dt = new Datatable($request);

        $dt->query = Invoices::query()->with(["project", "project.users"]);

        if (!$user->is_admin()) {
            $dt->query->whereHas("project.users", function ($q) use ($user) {
                $q->where("id", $user->id);
            });
        }

        $filters = $dt->filters;
        if ($filters['overdue'] ?? false) {
            $dt->query->where('status', 'unpaid')
                        ->where('due_date', "<", Carbon::today());
        }

        $dt->count()->order()->paginate()->result();

        $this->result['data'] = $dt->data;
        $this->result['iTotalDisplayRecords'] = $dt->count;
        $this->result['iTotalRecords'] = $dt->count;
        return $this->result;
    }
}
