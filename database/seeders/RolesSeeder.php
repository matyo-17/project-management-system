<?php

namespace Database\Seeders;

use App\Lib\SeedHelper;
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
            ['name' => 'super', 'admin' => 1, 'status' => 1],
            ['name' => 'admin', 'admin' => 1, 'status' => 1],
            ['name' => 'user', 'admin' => 0, 'status' => 1],
        ];
        DB::table('roles')->insert(SeedHelper::add_timestamps($data));
    }
}
