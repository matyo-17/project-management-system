<?php

namespace Database\Seeders;

use App\Models\Permissions;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super = Roles::where('name', 'super')->first();
        $super_permissions = Permissions::all()->pluck("id")->toArray();
        $super->permissions()->attach($super_permissions);

        $admin = Roles::where('name', 'admin')->first();
        $except = ['create_expense'];
        $admin_permissions = Permissions::whereNotIn('name', $except)->pluck("id")->toArray();
        $admin->permissions()->attach($admin_permissions);

        $user = Roles::where('name', 'user')->first();
        $include = ['read_project', 'read_invoice', 'create_expense', 'read_expense'];
        $user_permissions = Permissions::whereIn('name', $include)->pluck("id")->toArray();
        $user->permissions()->attach($user_permissions);
    }
}
