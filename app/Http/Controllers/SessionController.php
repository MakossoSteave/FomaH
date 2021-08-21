<?php

namespace App\Http\Controllers;

use App\Models\Chapitre;
use App\Models\Contenir_sessions_projet;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Session;
use App\Models\Formateur;
use App\Models\Formation;
use App\Models\FormationsContenirCours;
use App\Models\Lier_sessions_stagiaire;
use App\Models\Projet;
use App\Models\Qcm;
use App\Models\Score_qcm;
use App\Models\Stagiaire;
use App\Models\Statut;
use App\Models\Suivre_formation;
use App\Models\Titre;
use Illuminate\Support\Facades\Storage;
use PDF;
class SessionController extends Controller
{
    public function index()
    {
        $sessions = Session::select('sessions.*','formations.libelle','statut.statut','formateurs.nom','formateurs.prenom')
        ->leftJoin('formateurs','formateurs.id','sessions.formateur_id')
        ->join('formations','formations.id','sessions.formations_id')
        ->join('statut','statut.id','sessions.statut_id')  
        ->orderBy('updated_at','desc')->paginate(8)->setPath('session');      
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
          if($session->statut_id==3){
            $AllcoursSession=FormationsContenirCours::where('id_formation',$session->formations_id)
            ->where('numero_cours','!=',0)
            ->get();
            foreach($AllcoursSession as $c){
                $projet = Projet::where('etat',1)
                ->where('id_cours',$c->id_cours)
                ->first();
                $exists = Contenir_sessions_projet::where('id_session',$id)
                ->where('id_projet',$projet->id)->exists();
                
                if(!$exists){
                    Contenir_sessions_projet::create([
                        'id_projet' => $projet->id ,
                        'id_session' => $id ,
                        'statut_id' => 1
                    ]); 
                }
            }
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
                    'id_session'=> $idSession,
                    'id_formations' => $session->formations_id,
                    'id_cours' => $cours->id_cours,
                    'id_chapitre' => $chapitre->id_chapitre,
                    'id_chapitre_Courant'=> $chapitre->id_chapitre,
                    'nombre_chapitre_lu' => 0,
                    'progression' => 0
                ]);
            }else {
                return redirect()->back()->with('error','Aucun cours actif !'); 
            }
            }else if($existsAutreFormation!=null){
                return redirect()->back()->with('error','Stagiaire déjà inscrit dans une autre session');
            }
        }
        Lier_sessions_stagiaire::where('id_stagiaire',$id)
        ->where('id_session',$idSession)->update(array('etat' => $etat));
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
        $session=Session::find($id);
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
        if($etat==1 && $etat!=$session->etat){
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
        if(($etat==1 && $request->get('statut_id')==3) && ($etat!=$session->etat || $request->get('statut_id')!=$session->statut_id)){
            $AllcoursSession=FormationsContenirCours::where('id_formation',$request->get('formation_id'))
            ->where('numero_cours','!=',0)
            ->get();
            foreach($AllcoursSession as $c){
                $projet = Projet::where('etat',1)
                ->where('id_cours',$c->id_cours)
                ->first();
                $exists = Contenir_sessions_projet::where('id_session',$id)
                ->where('id_projet',$projet->id)->exists();
                dd($exists);
                if(!$exists){
                    Contenir_sessions_projet::create([
                        'id_projet' => $projet->id ,
                        'id_session' => $id ,
                        'statut_id' => 1
                    ]); 
                }
            }
        }
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
    $stagiaires=Lier_sessions_stagiaire::select('lier_sessions_stagiaires.*','users.image','stagiaires.nom','stagiaires.prenom','stagiaires.user_id','stagiaires.id as stagiaireID')
    ->join('stagiaires','stagiaires.id','lier_sessions_stagiaires.id_stagiaire')
    ->join('users','users.id','stagiaires.user_id')
    ->join('sessions','sessions.id','lier_sessions_stagiaires.id_session')
    ->where('id_session',$id)
    ->orderBy('etat','asc')->paginate(8)->setPath('StagiaireSession');
    $stagiairesCount = $stagiaires->count();
    $sessionStatut=(Session::find($id))->statut_id;
    $sessionEtat=(Session::find($id))->etat;
    $cursus = Session::select('formations.effectif')
    ->join('formations','formations.id','sessions.formations_id')
    ->where('sessions.id',$id)
    ->first();
    $effectif = $cursus->effectif;
    return view('admin.session.stagiaire.index',compact(['stagiaires','id','effectif']),['sessionStatut' =>$sessionStatut,'stagiairesCount' => $stagiairesCount,'sessionEtat'=>$sessionEtat]);
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
            }else {
                return redirect()->back()->with('error','Aucun cours actif !'); 
            }
            }else if($existsAutreFormation!=null){
                return redirect()->back()->with('error','Stagiaire déjà inscrit dans une autre session');
            }
        }
        Lier_sessions_stagiaire::create([
            'id_session'=> $id,
            'id_stagiaire'=>  $request->get('stagiaire_id'),
            'etat' =>  $request->get('etat')
        ]);
        return redirect('/StagiaireSession/'.$id)->with('success','Le stagiaire a été ajouté avec succès');
        }
    }
    public function removeStagiaire($id,$idSession)
    {
        Lier_sessions_stagiaire::where('id_stagiaire',$id)
        ->where('id_session',$idSession)
        ->delete();
        Suivre_formation::where('id_stagiaire',$id)
        ->where('id_session',$idSession)
        ->delete();
        return redirect()->back()->with('success','Stagiaire supprimé de la session avec succès');
    }
    public function destroy($id)
    {
        Session::where('id',$id)->delete();

        return redirect('/session')->with('success','Session supprimé avec succès');
    }

    public function createPDF($id,$idSession){
        $session= Session::find($idSession);
        $formation= Formation::find($session->formations_id);
        $stagiaire = Stagiaire::find($id);
        $data = [

            'prenom' => $stagiaire->prenom,
            'nom' => $stagiaire->nom,
            'type' => 'cursus',
            'titre' => $formation->libelle, 
            'date' =>  	$session->date_fin /*date('m/d/Y')*/

        ];

          

        $pdf = PDF::loadView('admin.session.diplome', $data);
        if($stagiaire->prenom)
        Storage::put("/public/session/$idSession/diplome/$stagiaire->prenom $stagiaire->nom diplome.pdf", $pdf->output());
        else
        Storage::put("/public/session/$idSession/diplome/$stagiaire->nom diplome.pdf", $pdf->output());
        $titre= Titre::where('stagiaire_id',$id)->where('intitule',$formation->libelle)->first();
        if($titre==null){
        do {
            $idTitre = rand(10000000, 99999999);
        } while(Titre::find($idTitre) != null);
        Titre::create([
            'id' =>  $idTitre,
            'intitule' => $formation->libelle,
            'date_obtention' => $session->date_fin,
            'stagiaire_id'=>$id,
            'session_id' => $idSession
        ]);
    }
    else {
        Titre::where('stagiaire_id',$id)->where('intitule',$formation->libelle)->update([
            'date_obtention' => $session->date_fin,
            'session_id' => $idSession
        ]);
    }
        return redirect()->back()->with('success','Diplôme crée avec succès');

    }
    public function progressionStagiaire($id,$idSession){
        $stagiaire = Suivre_formation::select('suivre_formations.*','cours.designation as NomCours','chapitres.designation as NomChapitre')
        ->join('cours','cours.id_cours','suivre_formations.id_cours')
        ->join('chapitres','chapitres.id_chapitre','suivre_formations.id_chapitre')
        ->where('id_stagiaire',$id)
        ->where('id_session',$idSession)
        ->first();
        return view('admin.session.stagiaire.progression.index',compact(['stagiaire']));
    }
    public function qcmStagiaire($id,$idSession){
      
        $qcms=Score_qcm::select('score_qcm.*','qcm.designation')
        ->join('lier_sessions_stagiaires','lier_sessions_stagiaires.id_stagiaire','score_qcm.stagiaire_id')
        ->join('sessions','sessions.id','lier_sessions_stagiaires.id_session')
        ->join('formations_contenir_cours','formations_contenir_cours.id_formation','sessions.formations_id')
        ->join('chapitres','chapitres.id_cours','formations_contenir_cours.id_cours')
        ->join('qcm', function($join)
                        {
                             $join->on('chapitres.id_chapitre', '=', 'qcm.id_chapitre');
                             $join->on('score_qcm.qcm_id','=','qcm.id');
                        }) 
        ->where('lier_sessions_stagiaires.id_session',$idSession)
        ->where('score_qcm.stagiaire_id',$id)
        ->orderBy('updated_at','desc')->paginate(8)->setPath('qcmStagiaire');
        return view('admin.session.stagiaire.progression.qcm',compact(['qcms']));
    }

    public function qcmViewStagiaire($id){
        $qcm = Qcm::find($id);
        return view('admin.session.stagiaire.progression.qcmView',compact(['qcm']));
    }
    public function projetStagiaire($id,$idSession){
      
         $qcms=Score_qcm::select('score_qcm.*','qcm.designation')
         ->join('lier_sessions_stagiaires','lier_sessions_stagiaires.id_stagiaire','score_qcm.stagiaire_id')
         ->join('sessions','sessions.id','lier_sessions_stagiaires.id_session')
         ->join('formations_contenir_cours','formations_contenir_cours.id_formation','sessions.formations_id')
         ->join('chapitres','chapitres.id_cours','formations_contenir_cours.id_cours')
         ->join('qcm', function($join)
                         {
                              $join->on('chapitres.id_chapitre', '=', 'qcm.id_chapitre');
                              $join->on('score_qcm.qcm_id','=','qcm.id');
                         }) 
         ->where('lier_sessions_stagiaires.id_session',$idSession)
         ->where('score_qcm.stagiaire_id',$id)
         ->orderBy('updated_at','desc')->paginate(8)->setPath('qcmStagiaire');
         return view('admin.session.stagiaire.progression.qcm',compact(['qcms']));
     }
}
