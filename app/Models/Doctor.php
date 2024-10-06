<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Doctor extends Model
{
    protected $table = "doctores";
    
    use HasFactory;
   
    
    //relacion con cita
   public function citas(){
        return $this->hasMany(Cita::class);
    }
}
