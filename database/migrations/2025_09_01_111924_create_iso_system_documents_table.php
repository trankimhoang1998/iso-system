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
            // PDF file (required)
            $table->string('pdf_file_name');
            $table->string('pdf_file_path');
            $table->string('pdf_file_type', 10);
            $table->integer('pdf_file_size');
            
            // Word file (optional)
            $table->string('word_file_name')->nullable();
            $table->string('word_file_path')->nullable();
            $table->string('word_file_type', 10)->nullable();
            $table->integer('word_file_size')->nullable();
            $table->enum('status', ['draft', 'approved', 'archived'])->default('draft');
            $table->string('symbol')->nullable()->comment('Ký hiệu');
            $table->year('issued_year')->nullable()->comment('Năm ban hành tài liệu');
            $table->string('document_number')->nullable()->comment('Số văn bản');
            $table->string('issuing_agency')->nullable()->comment('Cơ quan ban hành');
            $table->string('summary')->nullable()->comment('Trích yếu');
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