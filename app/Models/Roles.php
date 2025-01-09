<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roles extends Model
{
    use SoftDeletes;

    protected $table = "roles";

    public function permissions(): BelongsToMany {
        return $this->belongsToMany(
            Permissions::class, RolePermissions::class,
            "role_id", "permission_id",
        );
    }
}
