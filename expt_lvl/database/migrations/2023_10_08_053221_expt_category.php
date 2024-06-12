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
        Schema::create('expt_category', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('user_id'); // Link iwth user table
            $table->string('category_name', 100); // Category name with length of 100
            $table->tinyInteger('active')->default(1); // Default value of 1
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expt_category');
    }
};
