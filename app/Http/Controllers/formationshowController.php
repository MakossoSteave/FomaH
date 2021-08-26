<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\View\View;
use App\Models\Formation;



class formationshowController extends Controller
{
    public function index($id,$ref) : View
    {
        $data =  Formation::find($id);
        $user =  Formation::find($ref);

        return View('stagiaire.formation.Show',compact(['data','user']));

    }
}