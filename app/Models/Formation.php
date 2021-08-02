<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    public $incrementing = false;
    
    protected $fillable=[
        'id', 'libelle','description','image','volume_horaire','nombre_cours_total','nombre_chapitre_total','etat','reference','prix','userRef', 'categorie_id'
    ];

    // public function FormationContenirCours()
    // {
    //     return $this->belongsTo(FormationsContenirCours::class);
    // }
}