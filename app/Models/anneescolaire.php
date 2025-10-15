<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class anneescolaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'andebut',        
    ];

    public function libannee()
    {
        return $this->andebut . ' - ' . ($this->andebut + 1);
    }

}
