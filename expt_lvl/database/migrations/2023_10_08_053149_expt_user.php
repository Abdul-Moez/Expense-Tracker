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
        Schema::create('expt_user', function (Blueprint $table) {
            $table->id();
            $table->string('user_name', 50); // Max length of 100 characters
            $table->string('user_email', 255); // Max length of 255 characters
            $table->string('user_password', 60); // Max length of 60 characters
            $table->string('encryption_key', 60)->nullable(); // Max length of 60 characters
            $table->tinyInteger('user_role')->default(0); // Default value of 0
            $table->tinyInteger('first_login')->default(1); // Default value of 0
            $table->tinyInteger('is_pw_updated')->default(0); // Default value of 0
            $table->tinyInteger('active')->default(1); // Default value of 1
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expt_user');
    }
};