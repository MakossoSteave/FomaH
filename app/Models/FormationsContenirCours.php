<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormationsContenirCours extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $primaryKey = 'id_formation';
    
    protected $fillable=[
        'id_formation', 'id_cours', 'numero_cours'
    ];

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    public function formations()
    {
        return $this->belongsTo(Formations::class);
    }
}  