<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lier_sessions_stagiaire extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $primaryKey = 'id_session';

    protected $fillable=[
        'id_session', 'id_stagiaire','etat','validation','resultat_description'
    ];
}   