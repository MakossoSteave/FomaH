<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use App\Models\Sous_Matiere;
use App\Models\Categorie;
use App\Models\User;
use Illuminate\Http\Client\Request;
use  Illuminate\View\View;
use Illuminate\Support\Facades\DB;
class competenceController extends Controller
{
    
    public function show1(user $id) : View
    {
        $Matieres = Matiere::all();
        $Sous_matieres = Sous_matiere::all();

        return View('formateur.competence1', compact('id',['Matieres','Sous_matieres']));

    }

    public function show2(user $id) : View
    {
        $categories = Categorie::all();
        $Matieres = Matiere::all();
        $Sous_matieres = Sous_matiere::all();

        return View('formateur.competence2', compact('id',['categories','Matieres','Sous_matieres']));

    }
    /*
    public function getState(Request $request)
    {
        $matieres = DB::table("matieres")
        ->where("categorie_id",$request->categorie_id)
        ->pluck("designation_matiere","id");
        return response()->json($matieres);
    }
    */
    
}

/*
 public function index(){
        $roles = role::where('id', '!=', 1)->get();

        return view('auth.register', compact(['roles']));
    }
*/