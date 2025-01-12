<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expenses extends Model
{
    protected $table = "expenses";

    protected $fillable = [
        "description",
        "amount",
        "expense_date",
        "type",
        "type_details",
        "project_id",
    ];

    protected $hidden = [
        "created_at", "updated_at", "deleted_at",
    ];

    protected $attributes = [
        "status" => "pending",
    ];

    protected $appends = [
        'info_url',
    ];

    public function project(): BelongsTo {
        return $this->belongsTo(Projects::class, "project_id", "id");
    }
    
    public function infoUrl(): Attribute {
        return new Attribute(
            get: fn() => route("expense-info", ["id" => $this->id]),
        );
    }
}
