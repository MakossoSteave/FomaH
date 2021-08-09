<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    use HasFactory;

    public $incrementing = false;
    
    protected $fillable=[
        'id', 'designation'
    ];

    // public function FormationContenirCours()
    // {
    //     return $this->belongsTo(FormationsContenirCours::class);
    // }
}