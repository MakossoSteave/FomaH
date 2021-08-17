<?php

namespace App\Http\Controllers;

use App\Models\Chapitre;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Session;
use App\Models\Formateur;
use App\Models\Formation;
use App\Models\FormationsContenirCours;
use App\Models\Lier_sessions_stagiaire;
use App\Models\Stagiaire;
use App\Models\Statut;
use App\Models\Suivre_formation;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = Session::select('sessions.*','formations.libelle','statut.statut','formateurs.nom','formateurs.prenom')
        ->leftJoin('formateurs','formateurs.id','sessions.formateur_id')
        ->join('formations','formations.id','sessions.formations_id')
        ->join('statut','statut.id','sessions.statut_id')  
        ->get();        
        return view('admin.session.index',compact(['sessions']));
    }

    public function create()
    {
        $formateurs = Formateur::all();
        $formations = Formation::all();
        $statuts = Statut::all();

        return view('admin.session.create', compact(['formateurs'],['formations'],['statuts']));
    }

    public function store(Request $request)
    {
        $request->validate([
         'date_debut' => ['required'],
         'date_fin' => ['required'],
         'formation_id' => ['required']
        ]);

        do {
            $id = rand(10000000, 99999999);
        } while(Session::find($id) != null); 

        if ($request->get('formateur_id') == '') {
            $formateur = null;
        } else {
            $formateur = $request->get('formateur_id');
        }

        Session::create([
            'id' => $id,
            'date_debut' => $request->get('date_debut'),
            'date_fin' => $request->get('date_fin'),
            'etat' => 0,
            'formateur_id' => $formateur,
            'formations_id' => $request->get('formation_id'),
            'statut_id' => 2
        ]);
       
        return redirect('/session')->with('success','Session créé avec succès');
    }

    public function etat($id)
    {
        $session = Session::find($id);
        $etat = !$session->etat;

        if($etat==1){
            $cursus =Session::select('formations.*')
            ->join('formations','formations.id','sessions.formations_id')
            ->where('sessions.id',$id)
            ->first();

            if( $cursus->etat==0){
                return redirect()->back()->with('error',"L'Etat ne pas être modifié car le cursus est désactivé");
            }
            $stagiairesInscrits= Lier_sessions_stagiaire::select('lier_sessions_stagiaires.id_stagiaire')
            ->where('id_session',$id)
            ->where('etat',1)
            ->count();
            if($stagiairesInscrits==0)
          {
            return redirect()->back()->with('error',"L'Etat ne pas être modifié car aucun stagiaire actif n'est inscrit");
          }
           
        }        
        Session::where('id', $id)->update(array('etat' => $etat));
        return redirect()->back()->with('success','Etat modifié avec succès');
    }

    public function etatStagiaireSession($id,$idSession)
    {
        $etatStagiaire = Lier_sessions_stagiaire::where('id_stagiaire',$id)
        ->where('id_session',$idSession)
        ->first();
        $etat = !$etatStagiaire->etat;

        Lier_sessions_stagiaire::where('id_stagiaire',$id)
        ->where('id_session',$idSession)->update(array('etat' => $etat));
        if($etat ==1){
            $session=Session::find($idSession);
            $exists=Suivre_formation::where('id_stagiaire',$id)
            ->where('id_session',$idSession)->first();
              $existsAutreFormation=Lier_sessions_stagiaire::where('id_stagiaire',$id)
            ->where('id_session','!=',$idSession)->where('etat',1)->first();
            if( $exists==null && $existsAutreFormation==null){
                $cours=FormationsContenirCours::where('id_formation',$session->formations_id)->where('numero_cours',1)->first();
                if($cours){ $chapitre=Chapitre::where('id_cours',$cours->id_cours)
                    ->where('numero_chapitre',1)
                    ->where('etat',1)
                    ->first();
               
                Suivre_formation::create([
                    'id_stagiaire' => $id,
                    'id_session'=>$idSession,
                    'id_formations' => $session->formations_id,
                    'id_cours' => $cours->id_cours,
                    'id_chapitre' => $chapitre->id_chapitre,
                    'id_chapitre_Courant'=> $chapitre->id_chapitre,
                    'nombre_chapitre_lu' => 0,
                    'progression' => 0
                ]);
            }
            }else if($existsAutreFormation!=null){
                return redirect()->back()->with('error','Stagiaire déjà inscrit dans une autre session');
            }
        }
        return redirect()->back()->with('success','Etat modifié avec succès');
    }
    public function edit($id)
    {
       $session = Session::find($id);
       $formateurs = Formateur::all();
       $formations = Formation::all();
       $statuts = Statut::all();

       return view('admin.session.edit',compact(['session'],['formateurs'],['formations'],['statuts']));
    }
    public function editStagiaire($id,$idSession)
    {
        $stagiaire=Lier_sessions_stagiaire::
        where('id_session',$idSession)
        ->where('id_stagiaire',$id)
        ->first();
        return view('admin.session.stagiaire.edit',compact(['stagiaire']));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'date_debut' => ['required'],
            'date_fin' => ['required'],
            'etat' => [
                'required',
                 Rule::in(['0', '1'])],
            'formation_id' => ['required'],
            'statut_id' => ['required']
        ]);
        $etat=$request->get('etat');
        $message=null;
        if($etat==1){
            $cursus = Session::select('formations.*')
            ->join('formations','formations.id','sessions.formations_id')
            ->where('sessions.id',$id)
            ->first();
            if( $cursus->etat==0){
                $etat=0;
                $message="L'Etat ne pas être modifié car le cursus est désactivé";
            }else {
            $stagiairesInscrits= Lier_sessions_stagiaire::select('lier_sessions_stagiaires.id_stagiaire')
            ->where('id_session',$id)
            ->where('etat',1)
            ->count();
            if($stagiairesInscrits==0)
          {
            $etat=0;
            $message="L'Etat ne pas être modifié car aucun stagiaire actif n'est inscrit";
          }
        }
        }        
        Session::where('id', $id)->update([
            'date_debut' => $request->get('date_debut'),
            'date_fin' => $request->get('date_fin'),
            'etat' => $etat,
            'formateur_id' => $request->get('formateur_id'),
            'formations_id' => $request->get('formation_id'),
            'statut_id' => $request->get('statut_id')
        ]);
        if($message!=null){
            return redirect('/session')->with('success','Session modifié avec succès')
            ->with('error',$message);
        } else {
            return redirect('/session')->with('success','Session modifié avec succès');
        }
        
    }
    public function editResultStagiaire(Request $request, $id,$idSession)
    {
        $request->validate([
           
            'resultat' => ['required','string','max:3000'],
            'validation' => [
                'required',
                 Rule::in(['0', '1'])]
        ]);

        Lier_sessions_stagiaire:: where('id_session',$idSession)
        ->where('id_stagiaire',$id)->update([
            'validation' => $request->get('validation'),
            'resultat_description' => $request->get('resultat')
        ]);

        return redirect('/StagiaireSession/'.$idSession)->with('success','Résultat modifié avec succès');
    }
    public function Session_Stagiaire($id){
    $stagiaires=Lier_sessions_stagiaire::select('lier_sessions_stagiaires.*','users.image','stagiaires.nom','stagiaires.prenom','stagiaires.user_id','stagiaires.id as stagiaireID','sessions.statut_id as sessionStatut')
    ->join('stagiaires','stagiaires.id','lier_sessions_stagiaires.id_stagiaire')
    ->join('users','users.id','stagiaires.user_id')
    ->join('sessions','sessions.id','lier_sessions_stagiaires.id_session')
    ->where('id_session',$id)
    ->orderBy('etat','asc')->paginate(8)->setPath('StagiaireSession');
    $stagiairesCount = $stagiaires->count();
    //dd($stagiairesCount);
    $cursus = Session::select('formations.effectif')
    ->join('formations','formations.id','sessions.formations_id')
    ->where('sessions.id',$id)
    ->first();
    $effectif = $cursus->effectif;
    return view('admin.session.stagiaire.index',compact(['stagiaires','id','effectif']),['stagiairesCount' => $stagiairesCount]);
    }
    public function Session_Stagiaire_Ajout(Request $request,$id){
        $stagiairesInscrits= Lier_sessions_stagiaire::select('lier_sessions_stagiaires.id_stagiaire')
        ->where('id_session',$id)
        ->orWhere('etat',1)
        ->get();
        $stagiaires= Stagiaire::select('stagiaires.nom','stagiaires.prenom','stagiaires.id') 
        ->whereNotIn('id',$stagiairesInscrits)
        ->orderBy('created_at','desc')
        ->get();
        $request->session()->put('stagiaires', $stagiaires);
        return view('admin.session.stagiaire.create',compact(['stagiaires','id']));
    }

    public function store_stagiaire_session(Request $request,$id){
        $request->validate([
            'etat' => [
                'required',
                 Rule::in(['0', '1'])],
            'stagiaire_id' => ['required','in:'.$request->session()->get('stagiaires')->implode('id', ', ')]/*,
            'id' => ['required','regex:/[0-9]{8}/']*/
        ]);
        $stagiairesInscrits= Lier_sessions_stagiaire::select('lier_sessions_stagiaires.id_stagiaire')
        ->where('id_session',$id)
        ->where('etat',1)
        ->count();
        $cursus = Session::select('formations.*')
        ->join('formations','formations.id','sessions.formations_id')
        ->where('sessions.id',$id)
        ->first();
        $effectif = $cursus->effectif;
        
        if($stagiairesInscrits==$effectif){
            return redirect('/StagiaireSession/'.$id)->with('error','Nombre maximum de stagiaire atteint'); 
        }else{
        Lier_sessions_stagiaire::create([
            'id_session'=> $id,
            'id_stagiaire'=>  $request->get('stagiaire_id'),
            'etat' =>  $request->get('etat')
        ]);
        if($request->get('etat')==1){
            $session=Session::find($id);
            $exists=Suivre_formation::where('id_stagiaire',$request->get('stagiaire_id'))
            ->where('id_session',$id)->first();
            $existsAutreFormation=Lier_sessions_stagiaire::where('id_stagiaire',$request->get('stagiaire_id'))
            ->where('id_session','!=',$id)->where('etat',1)->first();
            if( $exists==null && $existsAutreFormation==null){
                $cours=FormationsContenirCours::where('id_formation',$session->formations_id)->where('numero_cours',1)->first();
                if($cours){ $chapitre=Chapitre::where('id_cours',$cours->id_cours)
                    ->where('numero_chapitre',1)
                    ->where('etat',1)
                    ->first();
               
                Suivre_formation::create([
                    'id_stagiaire' => $request->get('stagiaire_id'),
                    'id_session' => $id,
                    'id_formations' => $session->formations_id,
                    'id_cours' => $cours->id_cours,
                    'id_chapitre' => $chapitre->id_chapitre,
                    'id_chapitre_Courant'=> $chapitre->id_chapitre,
                    'nombre_chapitre_lu' => 0,
                    'progression' => 0
                ]);
            }
            }else if($existsAutreFormation!=null){
                return redirect()->back()->with('error','Stagiaire déjà inscrit dans une autre session');
            }
        }
        return redirect('/StagiaireSession/'.$id)->with('success','Le stagiaire a été ajouté avec succès');
        }
    }
    public function removeStagiaire($id,$idSession)
    {
        Lier_sessions_stagiaire::where('id_stagiaire',$id)
        ->where('id_session',$idSession)
        ->delete();

        return redirect()->back()->with('success','Stagiaire supprimé de la session avec succès');
    }
    public function destroy($id)
    {
        Session::where('id',$id)->delete();

        return redirect('/session')->with('success','Session supprimé avec succès');
    }
}
