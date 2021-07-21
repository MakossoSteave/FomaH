<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    public $incrementing = false;
    
    protected $fillable=[
        'id_cours', 'numero_cours','designation','image','nombre_chapitre','prix','etat', 'formation_id'
    ];
}