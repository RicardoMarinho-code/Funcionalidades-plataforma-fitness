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
        Schema::create('personal_notes', function (Blueprint $table) {
         $table->id();
         $table->unsignedBigInteger('personal_id'); // quem escreveu
         $table->unsignedBigInteger('student_id');  // sobre quem
         $table->text('note');
         $table->timestamp('note_date')->useCurrent();
         $table->timestamps();

         $table->foreign('personal_id')->references('id')->on('users')->onDelete('cascade');
         $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_notes');
    }
};
