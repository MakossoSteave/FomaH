<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable=[
        'id', 'description','date_debut','date_fin','etat','formateur_id','id_cours','statut_id'
    ];
}   