<?php

namespace Database\Seeders;

use App\Lib\SeedHelper;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $data = [
            [
                'username' => 'super',
                'name' => 'super',
                'email' => 'super@super.com',
                'password' => Hash::make('super123'),
                'status' => 1,
                'role_id' => 1,
            ],
            [
                'username' => 'admin',
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin123'),
                'status' => 1,
                'role_id' => 2,
            ],
            [
                'username' => 'user',
                'name' => 'user',
                'email' => 'user@user.com',
                'password' => Hash::make('user123'),
                'status' => 1,
                'role_id' => 3,
            ],
            [
                'username' => 'user2',
                'name' => 'user2',
                'email' => 'user2@user.com',
                'password' => Hash::make('user123'),
                'status' => 1,
                'role_id' => 3,
            ]
        ];
        DB::table('users')->insert(SeedHelper::add_timestamps($data));
    }
}
