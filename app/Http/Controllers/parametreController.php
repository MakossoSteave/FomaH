<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Formateur;
use App\Models\role;
use App\Models\Stagiaire;
use App\Models\User;
use  Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
    public function update(Request $request,$idUser){
       

        if ($request->has('email')) {
            $request->validate([
                'email' => ['string', 'email', 'max:191', 'unique:users']
            ]);
             User::where('id',$idUser)->update(["email"=>$request->get('email')]);
        }






        if(Auth::user()->role_id==3){
            $User= Stagiaire::where('user_id',$idUser)->first();
        }

        else if(Auth::user()->role_id==4){
            $User= Formateur::where('user_id',$idUser)->first();
        }

        $role = (role::find(Auth::user()->role_id))->type;
        $id = User::find($idUser);
        return View('stagiaire.parametre', compact(['id'],['User']),['role' => $role]);
    }
}