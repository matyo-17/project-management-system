<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private $user;

    public function __construct() {
        $this->user = Context::get("user");
    }

    public function dashboard(Request $request) {
        $dashboard = ($this->user->is_admin()) ? "admin" : "user";
        return $this->$dashboard($request);
    }

    private function admin(Request $request) {
        return view("pages.dashboard-admin");
    }

    private function user(Request $request) {
        return view("pages.dashboard-user");
    }

    public function summary(Request $request) {
        $sql = "SELECT
                    project_count, paid_amount, paid_count, unpaid_amount, unpaid_count, expense_amount, expense_count
                FROM (
                    (SELECT COUNT(id) AS project_count FROM projects WHERE deleted_at IS NULL) AS project_summary
                    JOIN
                    (SELECT SUM(amount) AS unpaid_amount, COUNT(id) AS unpaid_count FROM invoices WHERE `status` = 'unpaid' AND deleted_at IS NULL) AS unpaid_summary
                    JOIN
                    (SELECT SUM(amount) AS paid_amount, COUNT(id) AS paid_count FROM invoices WHERE `status` = 'paid' AND deleted_at IS NULL) AS paid_summary
                    JOIN
                    (SELECT SUM(amount) AS expense_amount, COUNT(id) AS expense_count FROM expenses WHERE `status` = 'approved' AND deleted_at IS NULL) AS expense_summary
                )";
        $summary = DB::select($sql)[0];

        $this->result['data'] = [
            "project_count" => $summary->project_count ?? 0,
            "paid_amount" => number_format($summary->paid_amount ?? 0,  2),
            "paid_count" => $summary->paid_count ?? 0,
            "unpaid_amount" => number_format($summary->unpaid_amount ?? 0,  2),
            "unpaid_count" => $summary->unpaid_count ?? 0,
            "expense_amount" => number_format($summary->expense_amount ?? 0,  2),
            "expense_count" => $summary->expense_count ?? 0,
        ];
        return response()->json($this->result);
    }
}
