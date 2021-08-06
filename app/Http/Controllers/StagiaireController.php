<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Stagiaire;
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
       // $formation  = Formation::find($ids);
        $Formation = Formation ::find($id);
        $user = $Formation->userRef;
        $al = User:: find($user);
        $referenceee = Formation::where("userRef",$user)->take(10)->get();
        
      
        //$databis =Formation::all();

       return view('stagiaire.formation.Show',compact(['Formation','al', 'referenceee']));
    }
        ->orderBy('stagiaires.created_at','desc')
    }
        ->paginate(5)->setPath('stagiaires');
        return view('admin.user.stagiaire.index',compact('stagiaires'));
        ->join('users','stagiaires.user_id','=','users.id')
        return redirect()->back()->with('success','Stagiaire supprimé avec succès');
    public function edit(){
    public function destroy($id)
        $stagiaires = Stagiaire::select('stagiaires.*','users.image','users.email','formateurs.nom as coachNom','formateurs.prenom as coachPrenom','organisations.designation as organisation','types_inscriptions.type as typeInscription')
    

    public function stagiaire(){
        $stagiaires = Stagiaire::select('stagiaires.*','users.image','users.email','formateurs.nom as coachNom','formateurs.prenom as coachPrenom','organisations.designation as organisation','types_inscriptions.type as typeInscription')
        ->leftJoin('types_inscriptions','stagiaires.type_inscription_id','=','types_inscriptions.id')
        ->leftJoin('organisations','stagiaires.organisation_id','=','organisations.id')
        ->leftJoin('formateurs','stagiaires.formateur_id','=','formateurs.id')
        ->join('users','stagiaires.user_id','=','users.id')
        ->orderBy('stagiaires.created_at','desc')
        ->paginate(5)->setPath('stagiaires');
        return view('admin.user.stagiaire.index',compact('stagiaires'));
    }
    public function edit(){
    }
    public function destroy($id)
    {
        $stagiaire = Stagiaire::where('id',$id)->first();
        $stagiaire->delete();
        User::where('id',$stagiaire->user_id)->delete();
        return redirect()->back()->with('success','Stagiaire supprimé avec succès');
    }
}