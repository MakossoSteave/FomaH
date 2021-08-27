<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qcm extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $table = "qcm";
    
    protected $fillable=[
        'id', 'designation','etat','id_chapitre'
    ];

    public function Question_qcm()
    {
        return $this->hasMany(Question_qcm::class,'qcm_id','id');       
    }

    public function Score_qcm()
    {
        return $this->hasMany(Score_qcm::class,'qcm_id','id');       
    }
}