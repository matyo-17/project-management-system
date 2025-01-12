<?php

namespace Database\Seeders;

use App\Lib\SeedHelper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ["name" => "create_project", "group" => "project"],
            ["name" => "read_project", "group" => "project"],
            ["name" => "update_project", "group" => "project"],
            ["name" => "delete_project", "group" => "project"],
            ["name" => "update_project_users", "group" => "project"],

            ["name" => "create_invoice", "group" => "invoice"],
            ["name" => "read_invoice", "group" => "invoice"],
            ["name" => "update_invoice", "group" => "invoice"],
            ["name" => "delete_invoice", "group" => "invoice"],
            ["name" => "update_invoice_status", "group" => "invoice"],

            ["name" => "create_expense", "group" => "expense"],
            ["name" => "read_expense", "group" => "expense"],
            ["name" => "update_expense", "group" => "expense"],
            ["name" => "delete_expense", "group" => "expense"],
            ["name" => "update_expense_status", "group" => "expense"],
        ];

        DB::table('permissions')->insert(SeedHelper::add_timestamps($data));
    }
}
