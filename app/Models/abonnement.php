<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class abonnement extends Model
{
    use HasFactory;

    
     function secteur(){
          return $this->belongsTo(secteurs::class, 'idsecteur', 'id');
        }
        
}
