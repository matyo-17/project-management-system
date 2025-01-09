<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Projects extends Model
{
    use SoftDeletes;

    protected $table = "projects";

    protected $fillable = [
        "title",
        "description",
        "start_date",
        "end_date",
        "budget",
        "status",
    ];

    protected $attributes = [
        "status" => "pending"
    ];

    public function users(): BelongsToMany {
        return $this->belongsToMany(
            User::class, UserProjects::class,
            "project_id", "user_id"
        );
    }

    public function invoices(): HasMany {
        return $this->hasMany(Invoices::class, "invoice_id", "id");
    }
}
