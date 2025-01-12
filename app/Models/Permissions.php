<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permissions extends Model
{
    use SoftDeletes;

    protected $table = "permissions";

    protected $fillable = [
        "name",
    ];

    protected $hidden = [
        "created_at", "updated_at", "deleted_at",
    ];

    public function roles(): BelongsToMany {
        return $this->belongsToMany(
            Roles::class, RolePermissions::class,
            "permission_id", "role_id",
        );
    }
}
