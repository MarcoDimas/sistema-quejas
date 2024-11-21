<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queja extends Model
{
    use HasFactory;

    protected $fillable = [
       'nombre',
       'email',
       'motivo',
       'descripcion',
       'estado',
       'dependencia_id',
       'area_id',
       'usuario_id',

    ];


    public function usuarios()
    {
      return $this->belongsTo(User::class);
    }

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class);
    }
}
