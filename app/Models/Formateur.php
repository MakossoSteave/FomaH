<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formateur extends Model
{
    use HasFactory;
    protected $fillable = [
        'etat','id','nom','prenom'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
