<?php

namespace App\Http\Controllers;

use App\Models\Formations;
use App\Models\User;

use Illuminate\Http\Request;

class StagiaireController extends Controller
{
    public function index(){
        $data = Formations::orderBy('id','desc')->paginate(8)->setPath('stagiaire');

        return view('stagiaire/index',compact(['data']));
    }
    public function show($id ,$ids )
    {
        $formation  = Formations::find($id);
        $user = User::find([$ids]);
      
        $databis =Formations::all();

       return view('stagiaire.formation.Show',compact(['formation','user']));
    }
    
}