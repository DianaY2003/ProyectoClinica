<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CitaPublica extends Model
{
    protected $table = ("publicas");
    use HasFactory;

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
