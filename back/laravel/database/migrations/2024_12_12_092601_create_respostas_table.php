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
        Schema::create('respostas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("id_pregunta");
            $table->foreign("id_pregunta")->references('id')->on('preguntas')->onDelete('cascade');

            $table->unsignedBigInteger("resposta1");
            $table->foreign("resposta1")->references('id')->on('users')->onDelete('cascade');
            
            $table->unsignedBigInteger("resposta2");
            $table->foreign("resposta2")->references('id')->on('users')->onDelete('cascade');
            
            $table->unsignedBigInteger("resposta3");
            $table->foreign("resposta3")->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger("id_alumno_emisor");
            $table->foreign("id_alumno_emisor")->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respostas');
    }
};
