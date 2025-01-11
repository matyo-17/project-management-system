<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectUsers extends Pivot
{
    use HasUuids;

    protected $table = "project_users";
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
}
