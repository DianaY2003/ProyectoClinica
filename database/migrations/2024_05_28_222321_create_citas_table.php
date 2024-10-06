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
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->time('hora');
            $table->string('motivo', 500);
            $table->string('estado', 255);
            $table->unsignedBigInteger('paciente_id'); // Clave foránea
            $table->unsignedBigInteger('doctor_id'); // Clave foránea
            $table->timestamps();
            $table->foreign('paciente_id')->references('id')->on('pacientes'); // Definir la relación con la tabla pacientes
            $table->foreign('doctor_id')->references('id')->on('doctores'); // Definir la relación con la tabla doctores
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
