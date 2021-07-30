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
        return $this->hasMany(Cours::class, 'id_cours', 'id_cours');
    }

    public function formations()
    {
        return $this->hasMany(Formation::class,'id', 'id_formation');
    }
}  