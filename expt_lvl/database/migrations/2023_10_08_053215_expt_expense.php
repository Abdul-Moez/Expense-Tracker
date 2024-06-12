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
        Schema::create('expt_expense', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('user_id'); // Link iwth user table
            $table->tinyInteger('account_id'); // Link with account table
            $table->tinyInteger('category_id'); // Link with category table
            $table->text('amount'); // Expense amount will be inserted in encrypted format
            $table->text('description'); // Expense description will be inserted in encrypted format
            $table->date('date'); // Date to only allow date format
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expt_expense');
    }
};
