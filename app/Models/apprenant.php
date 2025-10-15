<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class apprenant extends Model
{
    use HasFactory;
 function personne()
    {
        return $this->belongsTo(personne::class, 'idpersonne', 'id');
    }

}
