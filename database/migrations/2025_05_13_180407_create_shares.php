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
        Schema::create('shares', function (Blueprint $table) {
            $table->ulid('id')->primary(); 
            $table->foreignUlid('user_id')->constrained('users')->onDelete('cascade'); 
            $table->foreignUlid('file_id')->nullable()->constrained('files')->onDelete('cascade'); 
            $table->foreignUlid('directory_id')->nullable()->constrained('directories')->onDelete('cascade'); 
            $table->string('slug')->unique();
            $table->boolean('is_public')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shares');
    }
};