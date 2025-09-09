<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iso_directive_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable()->comment('Thuyết minh');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('iso_directive_categories')->onDelete('cascade');
            $table->index('parent_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iso_directive_categories');
    }
};