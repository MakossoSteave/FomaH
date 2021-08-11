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
}  