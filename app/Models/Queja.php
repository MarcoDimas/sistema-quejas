<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queja extends Model
{
    use HasFactory;

    protected $fillable = [
       'titulo',
       'descripcion',
       'estado',
       'usuario_id',
       'dependencia_id',
       'area_id',
    ];


    public function usuarios()
    {
      return $this->belongsTo(User::class);
    }

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class);
    }

    public function areas()
    {
        return $this->belongsTo(Area::class);
    }

    public function respuesta()
    {
        return $this->hasMany(Respuesta::class);
    }
}
