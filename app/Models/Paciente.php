<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paciente extends Model
{
     use HasFactory;
   protected $fillable = [
    'user_id',
    'nombres',
    'apellidos',
    'tipo_documento',
    'numero_documento',
    'fecha_nacimiento',
    'genero',
    'direccion',
    'telefono',
    'email',
    'grupo_sanguineo',
    'alergias',
    'enfermedades',
    'medicamentos',
    'habitos',
    'antecedentes',
    'odontograma',
    'contacto_emergencia',
    'telefono_emergencia',
    'observaciones',
];

//  protected $casts = [
//         'habitos'      => 'array',
//         'antecedentes' => 'array',
//     ];

public function user()
{
    // LA TABLA QUE TIENE LA FK(se usa belongsTo)
    return    $this->belongsTo(User::class);
}
}
