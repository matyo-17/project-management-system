<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected $hidden = [
        "created_at", "updated_at", "deleted_at",
    ];

    protected $attributes = [
        "status" => "pending"
    ];

    protected $appends = [
        'info_url',
    ];

    public function users(): BelongsToMany {
        return $this->belongsToMany(
            User::class, ProjectUsers::class,
            "project_id", "user_id"
        );
    }

    public function invoices(): HasMany {
        return $this->hasMany(Invoices::class, "project_id", "id");
    }

    public function expenses(): HasMany {
        return $this->hasMany(Expenses::class, "project_id", "id");
    }
    
    public function infoUrl(): Attribute {
        return new Attribute(
            get: fn() => route("project-info", ["id" => $this->id]),
        );
    }
}
