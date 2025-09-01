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
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type', 10);
            $table->integer('file_size');
            $table->unsignedBigInteger('document_type_id');
            $table->enum('status', ['draft', 'approved', 'archived'])->default('draft');
            $table->unsignedBigInteger('uploaded_by');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->boolean('is_public')->default(false);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('document_type_id')->references('id')->on('document_types')->onDelete('restrict');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
            $table->foreign('uploaded_by')->references('id')->on('users');
            $table->foreign('approved_by')->references('id')->on('users');
            
            $table->index(['document_type_id', 'status']);
            $table->index(['department_id', 'document_type_id']);
            $table->index('uploaded_by');
            $table->index('category_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};