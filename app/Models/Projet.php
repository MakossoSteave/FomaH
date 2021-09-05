<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable=[
        'id', 'description','etat','formateur_id','id_cours'
    ];

    public function Document()
    {
        return $this->belongsToMany(Document::class, ContenirDocumentsProjet::class, 'id_projet', 'id_document');
    }

    public function Session()
    {
        return $this->belongsToMany(Session::class,Contenir_sessions_projet::class,'id_projet','id_session');
    }

    public function Stagiaire()
    {
        return $this->belongsToMany(Stagiaire::class,Faire_projet::class,'id_projet','id_stagiaire');
    }
}
