<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score_qcm extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $table = "score_qcm";
    
    protected $fillable=[
        'id', 'resultat', 'stagiaire_id', 'qcm_id'
    ];
}  