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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->string('apellido', 50);
            $table->char('dui', 8);
            $table->char('telefono', 16);
            $table->date('fecha_nacimiento');
            $table->char('sexo', 1);
            $table->char('estado_civil', 1);
            $table->unsignedBigInteger('distrito_id'); // Clave foránea
            $table->foreign('distrito_id')->references('id')->on('distritos'); // Definir la relación con la tabla distritos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
