<?php

namespace App\Models;

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
    ];

    protected $attributes = [
        "status" => "unpaid"
    ];

    public function project(): BelongsTo {
        return $this->belongsTo(Projects::class, "project_id", "id");
    }
}
