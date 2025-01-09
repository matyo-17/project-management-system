<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roles extends Model
{
    use SoftDeletes;

    protected $table = "roles";

    public function users(): HasMany {
        return $this->hasMany(User::class, "role_id", "id");
    }

    public function permissions(): BelongsToMany {
        return $this->belongsToMany(
            Permissions::class, RolePermissions::class,
            "role_id", "permission_id",
        );
    }

    public static function find_by_name(string $name): ?self {
        return self::where("name", $name)->first();
    }
}
