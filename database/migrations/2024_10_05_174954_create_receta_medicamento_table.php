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
        Schema::create('receta_medicamento', function (Blueprint $table) {
            $table->id();
            $table->string("dosis");
            $table->integer("cantidad");
            $table->unsignedBigInteger('receta_id'); // Clave foránea
            $table->unsignedBigInteger('medicamento_id'); // Clave foránea
            $table->timestamps();
            $table->foreign('receta_id')->references('id')->on('recetas');
            $table->foreign('medicamento_id')->references('id')->on('medicamentos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receta_medicamento');
    }
};
