<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faire_projet extends Model
{

    protected $fillable=[
        'id_projet',
        'id_stagiaire',
        'lien',
        'statut_reussite',
        'resultat_description'
    ];
}
