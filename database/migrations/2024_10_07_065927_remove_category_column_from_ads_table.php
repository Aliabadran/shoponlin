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
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    public function down()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->string('category')->nullable(); // Add back the category column if the migration is rolled back
        });
    }
};
