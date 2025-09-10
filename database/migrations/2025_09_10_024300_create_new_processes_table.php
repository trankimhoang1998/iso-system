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
        Schema::create('new_processes', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Tiêu đề quy trình mới');
            $table->date('issue_date')->comment('Thời gian ban hành');
            $table->string('document_link')->comment('Link tài liệu');
            $table->integer('display_order')->default(0)->comment('Thứ tự hiển thị');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('new_processes');
    }
};
