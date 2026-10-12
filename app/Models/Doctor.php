<?php

namespace App\Models;

use App\Models\Especialidad;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
   protected $fillable=[
        
   ];
   public function user()
   {
    return $this->belongsTo(User::class);
   }
   public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);
    }
}
