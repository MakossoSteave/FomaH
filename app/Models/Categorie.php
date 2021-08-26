<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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