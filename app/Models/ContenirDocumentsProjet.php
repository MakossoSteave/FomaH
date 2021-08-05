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
}  