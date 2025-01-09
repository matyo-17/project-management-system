<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RolePermissions extends Pivot
{
    use HasUuids;

    protected $table = "role_permissions";
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
}
