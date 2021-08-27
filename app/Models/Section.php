<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    public $incrementing = false;
    
    protected $fillable=[
        'id', 'designation','contenu','image','etat','id_chapitre'
    ];

    public function Section()
    {
        return $this->hasOne(Chapitre::class,'id_chapitre','id_chapitre');
    }

    public function Chapitre()
    {
        return $this->belongsTo(Chapitre::class);
    }
}