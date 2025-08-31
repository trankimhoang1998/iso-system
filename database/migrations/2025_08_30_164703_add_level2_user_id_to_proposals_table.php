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
        Schema::table('proposals', function (Blueprint $table) {
            // Add level2_user_id field for Level 3 users to specify which Level 2 user receives their proposal
            $table->foreignId('level2_user_id')->nullable()->after('document_id')->constrained('users')->onDelete('set null');
            
            // Add index for better performance
            $table->index(['level2_user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropForeign(['level2_user_id']);
            $table->dropIndex(['level2_user_id', 'status']);
            $table->dropColumn('level2_user_id');
        });
    }
};
