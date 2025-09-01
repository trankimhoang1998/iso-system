<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type', 10);
            $table->integer('file_size');
            $table->enum('document_type', ['policy', 'procedure', 'form', 'manual', 'report', 'other']);
            $table->enum('status', ['draft', 'approved', 'archived'])->default('draft');
            $table->string('version', 20)->default('1.0');
            $table->unsignedBigInteger('uploaded_by');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->date('effective_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_public')->default(false);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('uploaded_by')->references('id')->on('users');
            $table->foreign('approved_by')->references('id')->on('users');
            
            $table->index(['document_type', 'status']);
            $table->index('uploaded_by');
            $table->index('category_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};