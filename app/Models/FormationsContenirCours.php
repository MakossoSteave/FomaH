<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormationsContenirCours extends Model
{
    use HasFactory;

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    public function formations()
    {
        return $this->belongsTo(Formations::class);
    }
}  