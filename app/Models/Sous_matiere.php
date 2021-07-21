<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sous_matiere extends Model
{
    use HasFactory;
    
    protected $fillable=[
        'designation_sous_matiere' 
    ];
}