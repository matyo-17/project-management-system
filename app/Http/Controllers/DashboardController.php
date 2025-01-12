<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;

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
}
