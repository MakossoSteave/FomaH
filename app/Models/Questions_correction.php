<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions_correction extends Model
{
    use HasFactory;

    public $incrementing = false;
    
    protected $fillable=[
        'id', 'reponse','image','etat','question_exercice_id'
    ];

    public function Exercice_has_question()
    {
        return $this->hasOne(Questions_exercice::class,'exercice_id','id');
    }

    public function Exercice_question()
    {
        return $this->belongsTo(Questions_exercice::class);
    }
}