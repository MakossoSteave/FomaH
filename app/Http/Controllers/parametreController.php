<?php

namespace App\Http\Controllers;

use App\Models\Formateur;
use App\Models\role;
use App\Models\Stagiaire;
use App\Models\User;
use  Illuminate\View\View;

class parametreController extends Controller
{
    
    public function show(user $id) : View
    {
        $role = (role::find($id->role_id))->type;
        
        if($id->role_id==3){
            $User= Stagiaire::where('user_id',$id->id)->first();
        }

        else if($id->role_id==4){
            $User= Formateur::where('user_id',$id->id)->first();
        }

        return View('stagiaire.parametre', compact(['id'],['User']),['role' => $role]);

    }
    public function store(){}
}