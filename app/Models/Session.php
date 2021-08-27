<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable=[
        'id', 'date_debut','date_fin','etat','formateur_id','formations_id','statut_id'
    ];
}   