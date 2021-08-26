<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participer_meeting extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $primaryKey = 'id_utilisateur';
    
    protected $fillable=[
        'id_utilisateur', 'id_meeting','validation'
    ];
}