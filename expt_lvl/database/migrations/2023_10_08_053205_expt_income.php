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
        Schema::create('expt_income', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('user_id'); // Link iwth user table
            $table->tinyInteger('account_id'); // Link with account table
            $table->text('source'); // Income source will be inserted in encrypted format
            $table->text('amount'); // Income amount will be inserted in encrypted format
            $table->text('description'); // Income description will be inserted in encrypted format
            $table->date('date'); // Date to only allow date format
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expt_income');
    }
};
