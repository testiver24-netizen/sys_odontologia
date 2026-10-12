<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    protected $table='especialidades';

    protected $guarded=[];
    //

    public function doctores()
    {
        return $this->hasMany(Doctor::class);
    }
}
