<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $primaryKey = 'id_cours';
    
    protected $fillable=[
        'id_cours', 'numero_cours','designation','image','nombre_chapitres','prix','etat', 'formateur'
    ];

    // public function FormationContenirCours()
    // {
    //     return $this->belongsTo(FormationsContenirCours::class);
    // }

    public function Chapitre()
    {
        return $this->hasMany(Chapitre::class,'id_cours','id_cours');       
    }
}