<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapitre extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $primaryKey = 'id_chapitre';

    protected $fillable=[
        'id_chapitre', 'numero_chapitre','designation','image','video','etat','id_cours'
    ];
    
    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }
}
