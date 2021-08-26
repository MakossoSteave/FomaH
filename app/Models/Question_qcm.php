<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question_qcm extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $table = "question_qcm";
    
    protected $fillable=[
        'id', 'question','explication','etat','qcm_id'
    ];

    public function Reponse_question_qcm()
    {
        return $this->hasMany(Reponse_question_qcm::class,'question_qcm_id','id');       
    }

    public function Qcm()
    {
        return $this->belongsTo(Qcm::class);
    }
}