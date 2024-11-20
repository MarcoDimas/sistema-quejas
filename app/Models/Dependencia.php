<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;

class Dependencia extends Model
{
    use HasFactory;

    protected $fillable = [
        
        'nombre',
        'descripcion',
        'estatus'
    ];

    public function areas()
    {
        return $this->hasMany(Area::class, 'id_dependencia');
    }
    

    public function quejas(){
        return $this->hasMany(Queja::class);
    }
}
