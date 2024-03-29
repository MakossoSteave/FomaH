<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formateur extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = [
        //'etat',
        'id','nom','prenom','telephone','user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
