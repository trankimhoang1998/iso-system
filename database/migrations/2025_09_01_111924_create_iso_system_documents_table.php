<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iso_system_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type', 10);
            $table->integer('file_size');
            $table->enum('status', ['draft', 'approved', 'archived'])->default('draft');
            $table->unsignedBigInteger('uploaded_by');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('iso_system_categories')->onDelete('set null');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
            $table->foreign('uploaded_by')->references('id')->on('users');
            
            $table->index(['status']);
            $table->index(['department_id']);
            $table->index('uploaded_by');
            $table->index('category_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iso_system_documents');
    }
};