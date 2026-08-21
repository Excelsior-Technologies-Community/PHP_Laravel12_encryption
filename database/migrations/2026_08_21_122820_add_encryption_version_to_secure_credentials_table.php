<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('secure_credentials', function (Blueprint $table) {
            $table->unsignedTinyInteger('encryption_version')
                ->default(1)
                ->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('secure_credentials', function (Blueprint $table) {
            $table->dropColumn('encryption_version');
        });
    }
};