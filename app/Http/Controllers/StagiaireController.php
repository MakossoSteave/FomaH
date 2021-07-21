<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\User;

use Illuminate\Http\Request;

class StagiaireController extends Controller
{
    public function index(){
        $data = Formation::orderBy('id','desc')->paginate(8)->setPath('stagiaire');

        return view('stagiaire/index',compact(['data']));
    }
    public function show($id)
    {
       // $formation  = Formations::find($ids);
        $formations = Formation ::find($id);
        $user = $formations->userRef;
        $al = User:: find($user);
        $referenceee = Formation::where("userRef",$user)->take(10)->get();
        
      
        //$databis =Formation::all();

       return view('stagiaire.formation.Show',compact(['formations','al', 'referenceee']));
    }
    
}