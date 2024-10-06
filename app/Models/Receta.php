<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    use HasFactory;

    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }

    // Relación de muchos a muchos: Una receta tiene muchos medicamentos
    public function medicamentos()
    {
        return $this->belongsToMany(Medicamento::class, 'receta_medicamento')->withPivot('cantidad','dosis')->withTimestamps();
    }
}
