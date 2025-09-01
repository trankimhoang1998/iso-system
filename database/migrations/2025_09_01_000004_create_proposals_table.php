<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('document_id')->constrained()->onDelete('cascade');
            $table->foreignId('level2_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('title');
            $table->enum('proposal_type', ['content_correction', 'format_improvement', 'additional_info', 'process_optimization', 'other']);
            $table->enum('priority', ['low', 'medium', 'high', 'urgent']);
            $table->text('description');
            $table->text('proposed_content')->nullable();
            $table->text('reason')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'implemented'])->default('pending');
            $table->text('response')->nullable();
            $table->foreignId('responded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index(['document_id', 'status']);
            $table->index(['level2_user_id', 'status']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};