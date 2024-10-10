<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    public function distrito()
    {
        return $this->belongsTo(Distrito::class);
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    public function imagenes() {
        return $this->hasMany(Imagen::class);
    }

}
