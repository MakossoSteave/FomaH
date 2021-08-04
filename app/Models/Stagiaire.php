<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stagiaire extends Model
{
    use HasFactory;
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','nom','prenom','telephone','user_id','formateur_id','type_inscription_id','organisation_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}