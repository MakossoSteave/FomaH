<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SousMatiere extends Model
{
    use HasFactory;
    
    protected $fillable=[
     'id', 'designation_sous_matiere', 'matiere_id'
    ];
    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }
}