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
            $table->unsignedBigInteger('category_id')->nullable()->comment('Danh mục tài liệu');
            
            // Document information
            $table->string('symbol')->nullable()->comment('Ký hiệu');
            $table->string('title')->comment('Tên tài liệu');
            $table->date('issued_date')->nullable()->comment('Thời gian ban hành');
            $table->date('latest_update')->nullable()->comment('Cập nhật mới nhất');
            
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
            
            // System fields
            $table->unsignedBigInteger('uploaded_by');
            $table->integer('display_order')->default(0)->comment('Thứ tự hiển thị');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('iso_system_categories')->onDelete('set null');
            $table->foreign('uploaded_by')->references('id')->on('users');
            
            $table->index('uploaded_by');
            $table->index('category_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iso_system_documents');
    }
};