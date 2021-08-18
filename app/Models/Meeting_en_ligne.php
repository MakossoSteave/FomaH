<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting_en_ligne extends Model
{
    use HasFactory;

    public $incrementing = false;
    
    protected $fillable=[
        'id', 'date_meeting','lien','statut_id','user_id','id_cours'
    ];
}