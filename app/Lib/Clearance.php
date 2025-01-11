<?php

namespace App\Lib;

use App\Models\User;

class Clearance {
    public bool $super, $admin;
    public array $permissions = [];

    public function __construct(User $user) {
        $role = $user->role;
        $permissions = $role->permissions->pluck("name")->toArray();
        
        $this->super = $role->name === "super";
        $this->admin = (bool) $role->admin;
        $this->permissions = array_fill_keys($permissions, 1);
    }

    public function has(string $key): bool {
        return isset($this->permissions[$key]);
    }

    public function has_any(array $keys): bool {
        foreach ($keys as $key) {
            if ($this->has($key)) return true;
        }
        return false;
    }
}
