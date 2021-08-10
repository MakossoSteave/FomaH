<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercice extends Model
{
    use HasFactory;

    public $incrementing = false;
    
    protected $fillable=[
        'id', 'enonce','image','etat','id_chapitre'
    ];

    public function Questions_exercice()
    {
        return $this->hasMany(Questions_exercice::class,'exercice_id','id');       
    }
}