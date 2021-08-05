<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    use HasFactory;
    
    
    protected $fillable=[
        'id','id_formateur','id_categorie','id_matiere', 'id_sous_matiere','id_niveau_scolaire'
    ];
    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }
}

/*
class Categorie extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable=[
        'id', 'designation'
    ];

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }
}   

*/