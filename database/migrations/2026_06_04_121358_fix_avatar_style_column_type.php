
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, fix existing records with invalid/truncated JSON in avatar_style
        $users = DB::table('users')->whereNotNull('avatar_style')->get();
        foreach ($users as $user) {
            $value = $user->avatar_style;
            // Try to decode it; if it fails, the data was truncated or invalid
            $decoded = json_decode($value, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                // Replace with default avatar style
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['avatar_style' => json_encode([
                        'face' => 'Perso-18',
                        'features' => 'Perso-23',
                        'hair' => 'Perso-28',
                    ])]);
            }
        }

        // Change the column type from string(50) to json
        Schema::table('users', function (Blueprint $table) {
            $table->json('avatar_style')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar_style', 50)->nullable()->change();
        });
    }
};
