<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string("description");
            $table->date("expense_date");
            $table->decimal("amount", 15, 2);
            $table->enum("type", ["travel", "equipment", "others"]);
            $table->string("type_details")->nullable();
            $table->enum("status", ["approved", "rejected", "pending"]);
            $table->foreignId("project_id");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
