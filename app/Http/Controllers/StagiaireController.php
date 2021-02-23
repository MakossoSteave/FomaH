<?php

namespace App\Http\Controllers;

use App\Models\Formations;

use Illuminate\Http\Request;

class StagiaireController extends Controller
{
    public function index(){
        $data = Formations::orderBy('id','desc')->paginate(8)->setPath('stagiaire');

        return view('stagiaire/index',compact(['data']));
    }
}