<?php

namespace App\Http\Controllers;


use App\Models\User;
use  Illuminate\View\View;

class parametreController extends Controller
{
    
    public function show(user $id) : View
    {
        return View('stagiaire.parametre', compact('id'));

    }
}