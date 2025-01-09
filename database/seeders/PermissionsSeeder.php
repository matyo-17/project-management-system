<?php

namespace Database\Seeders;

use App\Lib\SeederHelper;
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
            ["name" => "assign_project", "group" => "project"],

            ["name" => "create_invoice", "group" => "invoice"],
            ["name" => "read_invoice", "group" => "invoice"],
            ["name" => "update_invoice", "group" => "invoice"],
            ["name" => "delete_invoice", "group" => "invoice"],
            ["name" => "change_invoice_status", "group" => "invoice"],

            ["name" => "create_expense", "group" => "expense"],
            ["name" => "read_expense", "group" => "expense"],
            ["name" => "update_expense", "group" => "expense"],
            ["name" => "delete_expense", "group" => "expense"],
        ];

        DB::table('permissions')->insert(SeederHelper::add_timestamps($data));
    }
}
