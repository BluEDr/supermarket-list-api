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
        Schema::table('super_lists', function (Blueprint $table) {
            $table->boolean('partners_write_permition')->default(false)->after('partner_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('super_lists', function (Blueprint $table) {
            $table->dropColumn('partners_write_permition');
        });
    }
};
