<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{

    protected $table = "pagos";

    use HasFactory;

    //relacion con paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

     //relacion con tratamiento
     //momentanea con trabajos
     public function tratamiento()
     {
         return $this->belongsTo(Tratamiento::class);
     }

}
