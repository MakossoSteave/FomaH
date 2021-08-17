<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Titre extends Model
{
    use HasFactory;

    protected $table = "titres";

    public $incrementing = false;

    protected $fillable=[
        'id', 'intitule', 'date_obtention','stagiaire_id'
    ];
}   