<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    use HasFactory;
    
    protected $fillable=[
        'id_categorie','id_matiere', 'id_sous_matiere','id_niveau_scolaire'
    ];
}