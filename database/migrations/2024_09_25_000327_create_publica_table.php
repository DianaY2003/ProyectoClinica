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
        Schema::create('publicas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->date('fecha');
            $table->time('hora');
            $table->string('motivo', 255);
            $table->integer('telefono');
            $table->unsignedBigInteger('user_id'); // Clave foránea
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users'); // Definir la relación con la tabla users
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicas');
    }
};
