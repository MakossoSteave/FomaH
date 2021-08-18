<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenir_sessions_projet extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $primaryKey = 'id_projet';
    
    protected $fillable=[
        'id_projet', 'id_session', 'date_debut', 'date_fin', 'statut_id'
    ];
}  