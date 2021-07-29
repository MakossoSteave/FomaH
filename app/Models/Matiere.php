<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;
    
    protected $fillable=[
        'designation_matiere' 
    ];
    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }
}

/*
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }
}   

*/