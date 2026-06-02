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
        Schema::table('game_sessions', function (Blueprint $table) {
            $table->foreignId('current_module_id')->nullable()->constrained('modules')->nullOnDelete();
            $table->boolean('is_showing_results')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_sessions', function (Blueprint $table) {
            $table->dropForeign(['current_module_id']);
            $table->dropColumn(['current_module_id', 'is_showing_results']);
        });
    }
};
