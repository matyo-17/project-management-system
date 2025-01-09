<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserProjects extends Pivot
{
    use HasUuids;

    protected $table = "user_projects";
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
}
