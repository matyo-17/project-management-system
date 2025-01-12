<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoices extends Model
{
    use SoftDeletes;

    protected $table = "invoices";

    protected $fillable = [
        "inv_no",
        "due_date",
        "amount",
        "status",
        "project_id",
    ];

    protected $hidden = [
        "created_at", "updated_at", "deleted_at",
    ];

    protected $attributes = [
        "status" => "unpaid"
    ];

    protected $appends = [
        'info_url',
    ];

    public function project(): BelongsTo {
        return $this->belongsTo(Projects::class, "project_id", "id");
    }
    
    public function infoUrl(): Attribute {
        return new Attribute(
            get: fn() => route("invoice-info", ["id" => $this->id]),
        );
    }
}
