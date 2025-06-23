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
        Schema::create('progress_photos', function (Blueprint $table) {
            Schema::create('progress_photos', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('image_path');
                $table->date('photo_date');
                $table->float('weight')->nullable();
                $table->text('notes')->nullable();
                $table->enum('pose', ['frente', 'perfil', 'costas'])->nullable();
                $table->enum('privacy', ['privado', 'personal', 'publico'])->default('privado');
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_photos');
    }
};
