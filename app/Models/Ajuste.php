<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ajuste extends Model
{
   protected $fillable = [
    'nombre',
    'decripcion',
    'direccion',
    'telefono',
    'email',
    'divisa',
    'url_logo',
    'web',
];
}
