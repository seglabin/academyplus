<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classannesco extends Model
{
    use HasFactory;
    //'Classe', 'Année scolaire', 'Abonnement'
    function classetype()
    {
        return $this->belongsTo(classetype::class, 'idclasse', 'id');
    }
    function anneescolaire()
    {
        return $this->belongsTo(anneescolaire::class, 'idanneescolaire', 'id');
    }
    function abonnement()
    {
        return $this->belongsTo(abonnement::class, 'idabonnement', 'id');
    }

   public function libclasse(){
        return $this->classetype->libelle . ' ' .$this->groupe;
    }

   public function sigleclasse(){
        return $this->classetype->sigle . ' ' .$this->groupe;
    }

}
