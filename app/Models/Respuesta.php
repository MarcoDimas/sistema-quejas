<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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


    public function queja(){
      return $this->belongsTo(Queja::class);
    }


    public function usuarios(){
      return $this->BelongsTo(User::class,'user_id');
    }
}
