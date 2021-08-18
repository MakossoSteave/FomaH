<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faire_projet extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $primaryKey = 'id_projet';

    protected $fillable=[
        'id_projet', 'id_stagiaire','lien','statut_reussite','resultat_description'
    ];
}   