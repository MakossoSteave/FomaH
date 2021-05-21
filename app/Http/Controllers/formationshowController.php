<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\View\View;
use App\Models\Formations;



class formationshowController extends Controller
{
    public function index($id,$ref) : View
    {
        $data =  Formations::find($id);
        $user =  Formations::find($ref);

        return View('stagiaire.formation.Show',compact(['data','user']));

    }
}