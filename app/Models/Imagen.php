<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    use HasFactory;
    protected $table = "imagenes";
    protected $fillable = ['nombre', 'paciente_id'];

    public function paciente(){
        return $this->belongsTo(Paciente::class);
    }
}
