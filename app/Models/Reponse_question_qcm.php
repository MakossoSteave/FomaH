<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reponse_question_qcm extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $table = "reponse_question_qcm";
    
    protected $fillable=[
        'id', 'reponse','validation','etat','question_qcm_id'
    ];

    public function reponse_question_qcm()
    {
        return $this->hasOne(Question_qcm::class,'question_qcm_id','id');
    }

    public function Question_qcm()
    {
        return $this->belongsTo(Question_qcm::class);
    }
}