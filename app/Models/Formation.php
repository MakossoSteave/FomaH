<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;
    
    protected $fillable=[
        'libelle','description','volume_horaire','nombre_cours_total','nombre_chapitre_total','etat','reference','prix','userRef', 'categorie_id'
    ];
}