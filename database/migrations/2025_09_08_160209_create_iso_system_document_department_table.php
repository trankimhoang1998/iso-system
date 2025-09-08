<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iso_system_document_department', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('iso_system_document_id');
            $table->unsignedBigInteger('department_id');
            $table->timestamps();

            $table->foreign('iso_system_document_id')->references('id')->on('iso_system_documents')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            
            $table->unique(['iso_system_document_id', 'department_id'], 'doc_dept_unique');
            $table->index(['iso_system_document_id']);
            $table->index(['department_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iso_system_document_department');
    }
};