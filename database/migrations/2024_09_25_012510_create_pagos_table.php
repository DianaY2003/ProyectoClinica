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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id'); // Clave foránea
            $table->unsignedBigInteger('tratamiento_id'); // Clave foránea
            $table->string('tipo_pago', 20);
            $table->string('banco', 20);
            //fecha
            $table->date('fecha_pago');
            //monto
            $table->decimal('precio', 10, 2);
            $table->timestamps();
            $table->foreign('paciente_id')->references('id')->on('pacientes'); // Definir la relación con la tabla pacientes
            $table->foreign('tratamiento_id')->references('id')->on('tratamientos'); // Definir la relación con la tabla tratamientos

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
