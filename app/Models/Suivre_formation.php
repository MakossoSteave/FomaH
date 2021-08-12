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
        'id_stagiaire', 'id_formations', 'id_cours', 'id_chapitre', 'nombre_chapitre_lu', 'progression'
    ];

    public function Cours()
    {
        return $this->hasMany(Cours::class, 'id_cours', 'id_cours');
    }

    public function Chapitre()
    {
        return $this->hasMany(Chapitre::class, 'id_chapitre', 'id_chapitre');
    }
}  