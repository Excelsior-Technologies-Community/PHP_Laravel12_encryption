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
        Schema::create('secure_credentials', function (Blueprint $table) {
            $table->id();

            $table->string('service_name');
            $table->text('username')->nullable();
            $table->text('password')->nullable();
            $table->text('api_key')->nullable();
            $table->text('secret')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secure_credentials');
    }
};