<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use App\Models\Sous_Matiere;
use App\Models\User;
use  Illuminate\View\View;

class competenceController extends Controller
{
    
    public function show(user $id) : View
    {
        $Matieres = Matiere::all();
        $Sous_matieres = Sous_matiere::all();

        return View('formateur.competence', compact('id',['Matieres','Sous_matieres']));

    }
}

/*
 public function index(){
        $roles = role::where('id', '!=', 1)->get();

        return view('auth.register', compact(['roles']));
    }
*/