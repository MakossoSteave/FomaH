<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContenirDocumentsChapitre extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $primaryKey = 'id_doc';
    
    protected $fillable=[
        'id_doc', 'id_chapitre'
    ];
}  