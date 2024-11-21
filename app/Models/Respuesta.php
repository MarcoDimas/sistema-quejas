<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;

    protected $fillable = [
      'respondido_por',
      'correo_encargado',
      'descripcion',
      'archivo',
      'queja_id',
      'user_id'
    ];
}
