<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('management_documents', function (Blueprint $table) {
            $table->id();
            
            // Document information
            $table->string('document_number')->nullable()->comment('Số văn bản');
            $table->string('issuing_agency')->nullable()->comment('Cơ quan ban hành');
            $table->date('issued_date')->nullable()->comment('Thời gian ban hành');
            $table->text('summary')->nullable()->comment('Trích yếu');
            
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

            $table->foreign('uploaded_by')->references('id')->on('users');
            
            $table->index('uploaded_by');
            $table->index('issued_date');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('management_documents');
    }
};
