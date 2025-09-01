<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('can_view')->default(true);
            $table->boolean('can_download')->default(true);
            $table->unsignedBigInteger('granted_by');
            $table->timestamp('granted_at')->nullable();
            $table->timestamps();

            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('granted_by')->references('id')->on('users')->onDelete('cascade');
            
            $table->unique(['document_id', 'user_id']);
            $table->index(['user_id', 'can_view']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_permissions');
    }
};