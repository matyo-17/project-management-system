<?php

namespace Database\Seeders;

use App\Lib\SeederHelper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'super', 'status' => 1],
            ['name' => 'admin', 'status' => 1],
            ['name' => 'user', 'status' => 1],
        ];
        DB::table('roles')->insert(SeederHelper::add_timestamps($data));
    }
}
