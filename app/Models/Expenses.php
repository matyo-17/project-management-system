<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    protected $table = "expenses";

    protected $fillable = [
        "description",
        "expense_date",
        "type",
        "type_details",
        "project_id",
    ];
}
