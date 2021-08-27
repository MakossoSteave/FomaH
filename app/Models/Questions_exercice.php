<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions_exercice extends Model
{
    use HasFactory;

    public $incrementing = false;
    
    protected $fillable=[
        'id', 'question','etat','exercice_id'
    ];

    public function Questions_correction()
    {
        return $this->hasMany(Questions_correction::class,'question_exercice_id','id');       
    }

    public function Exercice()
    {
        return $this->belongsTo(Exercice::class);
    }
}