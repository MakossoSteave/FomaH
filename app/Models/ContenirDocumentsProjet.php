<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContenirDocumentsProjet extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $primaryKey = 'id_projet';
    
    protected $fillable=[
        'id_projet', 'id_document'
    ];

    public function Document()
    {
        return $this->hasMany(Document::class, 'id', 'id_document');
    }

    public function Projet()
    {
        return $this->hasMany(Projet::class, 'id', 'id_projet');
    }
}  