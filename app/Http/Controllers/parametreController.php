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
use Illuminate\Support\Facades\Hash;

class parametreController extends Controller
{
    
    public function show(user $id) : View
    {
        $role = (role::find($id->role_id))->type;
        
        if($id->role_id==3){
            $User= Stagiaire::where('user_id',$id->id)->first();
        }

        else if($id->role_id==4 || $id->role_id==1){
            $User= Formateur::where('user_id',$id->id)->first();
        }

        return View('stagiaire.parametre', compact(['id'],['User']),['role' => $role]);

    }
    public function update(Request $request,$idUser){
       
        if ($request->has('prenom')) {
            $request->validate([
                'prenom' => ['string',  'max:191']
            ]);
            if(Auth::user()->role_id==3){
                Stagiaire::where('user_id',$idUser)->update(["prenom"=>$request->get('prenom')]);
            }else if(Auth::user()->role_id==4 || Auth::user()->role_id==1 )
            {
                Formateur::where('user_id',$idUser)->update(["prenom"=>$request->get('prenom')]);  
            }
        }
        else if ($request->has('email')) {
            $request->validate([
                'email' => ['string', 'email', 'max:191', Rule::unique('users')->where(function ($query) use($idUser) {
                    
                           return $query->where('id',"!=", $idUser);})]
            ]);
             User::where('id',$idUser)->update(["email"=>$request->get('email')]);
        }
        else if ($request->has('Nouveau_motdepasse')) {
            $request->validate([
                'motdepasse' => ['required', 'string', 'min:8'],
                'Nouveau_motdepasse' => ['string', 'min:8'/*, 'confirmed'*/]
            ]);
            $newMdp=Hash::make($request->get('Nouveau_motdepasse'));
            $oldMdp=$request->get('motdepasse');
            $oldMdpBD=(User::find($idUser))->password;
            if(Hash::check($oldMdp,$oldMdpBD)){
             User::where('id',$idUser)->update(["password"=>$newMdp]);
            }else {
                return redirect('/parametre/'.intval($idUser))->with('error','Mot de passe incorrecte !');
            }
            }
        else if ($request->has('telephone')) {
            $request->validate([
                'telephone' => ['regex:/[0-9]{10}/']
            ]);
            if(Auth::user()->role_id==3){
                Stagiaire::where('user_id',$idUser)->update(["telephone"=>$request->get('telephone')]);
            }else if(Auth::user()->role_id==4 || Auth::user()->role_id==1 )
            {
                Formateur::where('user_id',$idUser)->update(["telephone"=>$request->get('telephone')]);  
            }
        }
/*
        if(Auth::user()->role_id==3){
            $User= Stagiaire::where('user_id',$idUser)->first();
        }

        else if(Auth::user()->role_id==4){
            $User= Formateur::where('user_id',$idUser)->first();
        }

        $role = (role::find(Auth::user()->role_id))->type;
        $id = User::find($idUser);*/
        return //View('stagiaire.parametre', compact(['id'],['User']),['role' => $role])->with('success','Modifié avec succés');
        redirect('/parametre/'.intval($idUser))->with('success','Modifié avec succés');
    
}
}