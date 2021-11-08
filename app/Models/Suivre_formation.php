<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suivre_formation extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $primaryKey = 'id_stagiaire';
    
    protected $fillable=[
        'id_stagiaire', 'id_formations', 'id_cours', 'id_chapitre', 'nombre_chapitre_lu', 'progression','id_chapitre_Courant','id_projet','id_qcm','id_session'
    ];
    
    // public function Stagiaire()
    // {
    //     return $this->belongsTo(Stagiaire::class, 'id_stagiaire', 'id');
    // }

    public function Cours()
    {
        return $this->hasMany(Cours::class, 'id_cours', 'id_cours');
    }

    public function Chapitre()
    {
        return $this->hasMany(Chapitre::class, 'id_chapitre', 'id_chapitre');
    }
}  