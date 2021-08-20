<?php

namespace App\Http\Controllers;

use App\Models\Suivre_formation;
use App\Models\FormationsContenirCours;
use App\Models\Stagiaire;
use App\Models\Formation;
use App\Models\Cours;
use App\Models\Qcm;
use App\Models\Score_qcm;
use App\Models\Exercice;
use App\Models\Chapitre;
use App\Models\Projet;
use App\Models\Session;
use App\Models\Lier_sessions_stagiaire;
use App\Models\Faire_projet;
use App\Models\Contenir_sessions_projet;
use App\Models\Participer_meeting;
use App\Models\Meeting_en_ligne;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IntranetController extends Controller
{
    public function index(){
       
        $idUserAuth=null;
        $idUserRole=null;

        if(Auth::user()){

        $idUserAuth=Auth::user()->id;
        $idUserRole=Auth::user()->role_id;}
        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();
        if($stagiaire){
           $SuivreFormation = Suivre_formation::select('suivre_formations.*')
            ->join('sessions','sessions.id','suivre_formations.id_session')
            ->join('lier_sessions_stagiaires','lier_sessions_stagiaires.id_stagiaire','suivre_formations.id_stagiaire')
            ->where('suivre_formations.id_stagiaire', $stagiaire->id)
            ->where('lier_sessions_stagiaires.etat',1)
            ->where('sessions.etat',1)
            ->where('sessions.statut_id',3)->exists();
		}
		else {
		$SuivreFormation = false;
		}
        if(!$SuivreFormation){
            if($idUserRole==2)
            return redirect("/centre");
            else if($idUserRole==3)
            return redirect("/stagiaire");
            
            else if($idUserRole==4)
            
            return redirect("/formateur");
            else if($idUserRole==5)
            
            return redirect("/organisme");
            else
            return redirect("/");
        }

        
        
        $countFormation = Suivre_formation::select('suivre_formations.*')
        ->join('sessions','sessions.id','suivre_formations.id_session')->where('id_stagiaire', $stagiaire->id)->where('sessions.etat',1)->where('sessions.statut_id',3)->count();
       
        $formationName = null;

        $session = null;

        if ($countFormation == 1) {
            $formation = Suivre_formation::select('suivre_formations.*')
            ->join('sessions','sessions.id','suivre_formations.id_session')->where('id_stagiaire', $stagiaire->id)->where('sessions.etat',1)->where('sessions.statut_id',3)->first();

/*
            $coursFormations = FormationsContenirCours::where('id_formation', $formation->id_formations)->get();

            foreach($coursFormations as $coursFormation) {
                $nombreChapitres = Cours::where('id_cours', $coursFormation->id_cours)->first();
                $arrayNombreChapitre[] = $nombreChapitres['nombre_chapitres'];
            }

            $arraySumTotalChapitre = array_sum($arrayNombreChapitre);
       */
            // nombre_chapitre_total actif dans formations
            $SumTotalChapitre = (Formation::find($formation->id_formations))->nombre_chapitre_total;
            $sessionStagiaire = Lier_sessions_stagiaire::where('id_stagiaire', $stagiaire->id)
            ->where('id_session',$formation->id_session)->first();

            $session = Session::where('id', $sessionStagiaire->id_session)->first();

            $formation = Suivre_formation::select('suivre_formations.*')
            ->join('sessions','sessions.id','suivre_formations.id_session')->where('id_stagiaire', $stagiaire->id)->where('sessions.etat',1)->where('sessions.statut_id',3)->first();

            $formationName = Formation::where('id', $formation->id_formations)->first();

            $progress = intval(($formation->nombre_chapitre_lu
            /*$arraySumTotalChapitre*/ /$SumTotalChapitre)*100);
        }

        return view('stagiaire.intranet.index', compact(['formationName'], ['session'], ['progress']));
    }

    public function preIndex() {
        $idUserAuth=null;
        $idUserRole=null;

        if(Auth::user()){

        $idUserAuth=Auth::user()->id;
        $idUserRole=Auth::user()->role_id;}
        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();
        if($stagiaire){
           $SuivreFormation = Suivre_formation::select('suivre_formations.*')
            ->join('sessions','sessions.id','suivre_formations.id_session')
            ->join('lier_sessions_stagiaires','lier_sessions_stagiaires.id_stagiaire','suivre_formations.id_stagiaire')
            ->where('suivre_formations.id_stagiaire', $stagiaire->id)
            ->where('lier_sessions_stagiaires.etat',1)
            ->where('sessions.etat',1)
            ->where('sessions.statut_id',3)->exists();
		}
		else {
		$SuivreFormation = false;
		}
        if(!$SuivreFormation){
            if($idUserRole==2)
            return redirect("/centre");
            else if($idUserRole==3)
            return redirect("/stagiaire");
            
            else if($idUserRole==4)
            
            return redirect("/formateur");
            else if($idUserRole==5)
            
            return redirect("/organisme");
            else
            return redirect("/");
        }

      

        $formation = Suivre_formation::select('suivre_formations.*')
        ->join('sessions','sessions.id','suivre_formations.id_session')->where('id_stagiaire', $stagiaire->id)->where('sessions.etat',1)->where('sessions.statut_id',3)->first();
        
        $countFormation = Suivre_formation::select('suivre_formations.*')
        ->join('sessions','sessions.id','suivre_formations.id_session')->where('id_stagiaire', $stagiaire->id)->where('sessions.etat',1)->where('sessions.statut_id',3)->count();
        
        $sessionStagiaire = Lier_sessions_stagiaire::where('id_stagiaire', $stagiaire->id)->where('id_session',$formation->id_session)->first();

        if($sessionStagiaire){
            $session = Session::where('id', $sessionStagiaire->id_session)->first();
        } else {
            $session=null;
        }

        $sessionStagiaire = Lier_sessions_stagiaire::where('id_stagiaire', $stagiaire->id)->where('id_session',$formation->id_session)->first();

        $session = Session::where('id', $sessionStagiaire->id_session)->first();
        $sessionProjets = Contenir_sessions_projet::where('id_session', '=' ,$session->id)->get();
        foreach ($sessionProjets as $sessionProjet) {
        

        if (date('Y-m-d') >= $sessionProjet->date_debut && date('Y-m-d') <= $sessionProjet->date_fin) {

            Contenir_sessions_projet::where([
                ['id_session', '=' ,$sessionProjet->id_session],
                ['id_projet','=', $sessionProjet->id_projet]
            ])->update([
                'statut_id' => 3
            ]);

        } else if(date('Y-m-d') < $sessionProjet->date_debut) {

            Contenir_sessions_projet::where([
                ['id_session', '=' ,$sessionProjet->id_session],
                ['id_projet','=',$sessionProjet->id_projet]
            ])->update([
                'statut_id' => 1
            ]);

        } else if(date('Y-m-d') > $sessionProjet->date_fin) {

            Contenir_sessions_projet::where([
                ['id_session', '=' ,$sessionProjet->id_session],
                ['id_projet','=', $sessionProjet->id_projet]
            ])->update([
                'statut_id' => 4
            ]);
        } 
    }
        $meetings = Participer_meeting::where('id_utilisateur', $idUserAuth)->get();

        $meeting = Participer_meeting::where('id_utilisateur', $idUserAuth)->count();

        $sessionLives = null;

        if($meeting != 0) {

            $meetings = Participer_meeting::where('id_utilisateur', $idUserAuth)->get();

            foreach ($meetings as $meeting) {
                $sessionLives[] = Meeting_en_ligne::where('id', $meeting->id_meeting)->where('id_cours', $formation->id_cours)->first();
            }
        }

        if ($sessionLives != null) {
            foreach ($sessionLives as $sessionLive) {
                $endMeeting = date('Y-m-d H:i:s', strtotime($sessionLive->date_meeting.' +2 hours'));
    
                if(date('Y-m-d H:i:s') < $sessionLive->date_meeting) {
    
                    $sessionLive->update([
                        'statut_id' => 1
                    ]);
    
                } else if(date('Y-m-d H:i:s') > $endMeeting) {
    
                    $sessionLive->update([
                        'statut_id' => 4
                    ]);
                    
                } else if(date('Y-m-d H:i:s') >= $sessionLive->date_meeting && date('Y-m-d H:i:s') <= $endMeeting) {
    
                    $sessionLive->update([
                        'statut_id' => 3
                    ]);
                }
            }
        }

        if ($session && $countFormation == 1 && date('Y-m-d') >= $session->date_debut && date('Y-m-d') <= $session->date_fin) {

            Session::where('id', $sessionStagiaire->id_session)->update([
                'statut_id' => 3
            ]);
 
            return redirect('/intranet');

        } else if($session && $countFormation == 1 && date('Y-m-d') < $session->date_debut) {

            Session::where('id', $sessionStagiaire->id_session)->update([
                'statut_id' => 2
            ]);

            return redirect('/intranet');

        } else if($session && $countFormation == 1 && date('Y-m-d') > $session->date_fin) {

            Session::where('id', $sessionStagiaire->id_session)->update([
                'statut_id' => 5
            ]);

            return redirect('/intranet');
        } else {
            return redirect('/stagiaire');
        }
    }

    public function oneChapitre() {
        $idUserAuth=null;
        $idUserRole=null;

        if(Auth::user()){

        $idUserAuth=Auth::user()->id;
        $idUserRole=Auth::user()->role_id;}
        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();
        if($stagiaire){
           $SuivreFormation = Suivre_formation::select('suivre_formations.*')
            ->join('sessions','sessions.id','suivre_formations.id_session')
            ->join('lier_sessions_stagiaires','lier_sessions_stagiaires.id_stagiaire','suivre_formations.id_stagiaire')
            ->where('suivre_formations.id_stagiaire', $stagiaire->id)
            ->where('lier_sessions_stagiaires.etat',1)
            ->where('sessions.etat',1)
            ->where('sessions.statut_id',3)->exists();
		}
		else {
		$SuivreFormation = false;
		}
        if(!$SuivreFormation){
            if($idUserRole==2)
            return redirect("/centre");
            else if($idUserRole==3)
            return redirect("/stagiaire");
            
            else if($idUserRole==4)
            
            return redirect("/formateur");
            else if($idUserRole==5)
            
            return redirect("/organisme");
            else
            return redirect("/");
        }

        
        
        $countFormation = Suivre_formation::select('suivre_formations.*')
        ->join('sessions','sessions.id','suivre_formations.id_session')->where('id_stagiaire', $stagiaire->id)->where('sessions.etat',1)->where('sessions.statut_id',3)->count();

        $qcmCount = 0;

        $scoreCount = 0;

        $exerciceCount = 0;

        $projetCount = 0;

        $cours = null;

        $chapitre = null;

        if ($countFormation == 1) {
            $formation = Suivre_formation::select('suivre_formations.*')
            ->join('sessions','sessions.id','suivre_formations.id_session')->where('id_stagiaire', $stagiaire->id)->where('sessions.etat',1)->where('sessions.statut_id',3)->first();

            $qcmCount = Qcm::where('etat',1)->where('id_chapitre', $formation->id_chapitre)->count();

            $cours = Cours::where('etat',1)->where('id_cours', $formation->id_cours)->first();

            $chapitre = Suivre_formation::where('id_chapitre', $formation->id_chapitre)->with('Chapitre.Section')->first();

            $qcm = Qcm::where('etat',1)->where('id_chapitre', $formation->id_chapitre)->first();
    
            $scoreCount = Score_qcm::where([
                ['qcm_id', $qcm->id],
                ['stagiaire_id', $stagiaire->id]
            ])->count();
                
            $exerciceCount = Exercice::where('etat',1)->where('id_chapitre', $formation->id_chapitre)->count();

            $chapitreMax = Chapitre::where('etat',1)->where('id_cours', $formation->id_cours)->max('numero_chapitre');

            $chap = Chapitre::where('etat',1)->where('id_chapitre', $formation->id_chapitre)->first();

            if($chapitreMax == $chap->numero_chapitre) {
                $projetCount = Projet::where('etat',1)->where('id_cours', $formation->id_cours)->count();
            }
        }

        return view('stagiaire.intranet.cours.index', compact(['chapitre'], ['cours'],['qcmCount'],['scoreCount'],['exerciceCount'],['projetCount']));
    }

    public function qcm() {
        $idUserAuth=null;
        $idUserRole=null;

        if(Auth::user()){

        $idUserAuth=Auth::user()->id;
        $idUserRole=Auth::user()->role_id;}
        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();
        if($stagiaire){
           $SuivreFormation = Suivre_formation::select('suivre_formations.*')
            ->join('sessions','sessions.id','suivre_formations.id_session')
            ->join('lier_sessions_stagiaires','lier_sessions_stagiaires.id_stagiaire','suivre_formations.id_stagiaire')
            ->where('suivre_formations.id_stagiaire', $stagiaire->id)
            ->where('lier_sessions_stagiaires.etat',1)
            ->where('sessions.etat',1)
            ->where('sessions.statut_id',3)->exists();
		}
		else {
		$SuivreFormation = false;
		}
        if(!$SuivreFormation){
            if($idUserRole==2)
            return redirect("/centre");
            else if($idUserRole==3)
            return redirect("/stagiaire");
            
            else if($idUserRole==4)
            
            return redirect("/formateur");
            else if($idUserRole==5)
            
            return redirect("/organisme");
            else
            return redirect("/");
        }

        
        
        $formation = Suivre_formation::select('suivre_formations.*')
        ->join('sessions','sessions.id','suivre_formations.id_session')->where('id_stagiaire', $stagiaire->id)->where('sessions.etat',1)->where('sessions.statut_id',3)->first();

        $cours = Cours::where('etat',1)->where('id_cours', $formation->id_cours)->first();

        $qcms = Qcm::where('etat',1)->where('id_chapitre', $formation->id_chapitre)->with('Question_qcm.Reponse_question_qcm')->get();

        $qcm = Qcm::where('etat',1)->where('id_chapitre', $formation->id_chapitre)->first();
    
        $scoreCount = Score_qcm::where('qcm_id', $qcm->id)->count();
       
        $score = null;

        if ($scoreCount == 1) {
            $score = Score_qcm::where('qcm_id', $qcm->id)->first();
        }

        return view('stagiaire.intranet.qcm.index', compact(['qcms'],['cours'],['formation'],['score']));
    }

    public function score(Request $request) {
        $idUserAuth=null;
        $idUserRole=null;

        if(Auth::user()){

        $idUserAuth=Auth::user()->id;
        $idUserRole=Auth::user()->role_id;}
        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();
        if($stagiaire){
           $SuivreFormation = Suivre_formation::select('suivre_formations.*')
            ->join('sessions','sessions.id','suivre_formations.id_session')
            ->join('lier_sessions_stagiaires','lier_sessions_stagiaires.id_stagiaire','suivre_formations.id_stagiaire')
            ->where('suivre_formations.id_stagiaire', $stagiaire->id)
            ->where('lier_sessions_stagiaires.etat',1)
            ->where('sessions.etat',1)
            ->where('sessions.statut_id',3)->exists();
		}
		else {
		$SuivreFormation = false;
		}
        if(!$SuivreFormation){
            if($idUserRole==2)
            return redirect("/centre");
            else if($idUserRole==3)
            return redirect("/stagiaire");
            
            else if($idUserRole==4)
            
            return redirect("/formateur");
            else if($idUserRole==5)
            
            return redirect("/organisme");
            else
            return redirect("/");
        }

        $resultat = 0;

        for ($idRadio=0; $idRadio < count($request->get('reponseNameRadio')); $idRadio++) { 

            if($request->reponseNameRadio[$idRadio] == 1) {
                $resultat = $resultat+1;
            }
        }

        do {
            $idScore = rand(10000000, 99999999);
        } while(Score_qcm::find($idScore) != null);

        

        Score_qcm::create([
            'id' => $idScore,
            'resultat' => ($resultat/count($request->get('reponseNameRadio')))*100,
            'stagiaire_id' => $stagiaire->id,
            'qcm_id' => $request->get('qcm_id')
        ]);

        return redirect('/intranet/qcm');
    }

    public function exercice() {
        $idUserAuth=null;
        $idUserRole=null;

        if(Auth::user()){

        $idUserAuth=Auth::user()->id;
        $idUserRole=Auth::user()->role_id;}
        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();
        if($stagiaire){
           $SuivreFormation = Suivre_formation::select('suivre_formations.*')
            ->join('sessions','sessions.id','suivre_formations.id_session')
            ->join('lier_sessions_stagiaires','lier_sessions_stagiaires.id_stagiaire','suivre_formations.id_stagiaire')
            ->where('suivre_formations.id_stagiaire', $stagiaire->id)
            ->where('lier_sessions_stagiaires.etat',1)
            ->where('sessions.etat',1)
            ->where('sessions.statut_id',3)->exists();
		}
		else {
		$SuivreFormation = false;
		}
        if(!$SuivreFormation){
            if($idUserRole==2)
            return redirect("/centre");
            else if($idUserRole==3)
            return redirect("/stagiaire");
            
            else if($idUserRole==4)
            
            return redirect("/formateur");
            else if($idUserRole==5)
            
            return redirect("/organisme");
            else
            return redirect("/");
        }

       

        $formation = Suivre_formation::select('suivre_formations.*')
        ->join('sessions','sessions.id','suivre_formations.id_session')->where('id_stagiaire', $stagiaire->id)->where('sessions.etat',1)->where('sessions.statut_id',3)->first();

        $cours = Cours::where('etat',1)->where('id_cours', $formation->id_cours)->first();

        $chapitre = Chapitre::where('etat',1)->where('id_chapitre', $formation->id_chapitre)->first();

        $exercices = Exercice::where('etat',1)->where('id_chapitre', $formation->id_chapitre)->with('Questions_exercice.Questions_correction')->get();

        $qcm = Qcm::where('etat',1)->where('id_chapitre', $formation->id_chapitre)->first();

        if($qcm) {
            $scoreCount = Score_qcm::where([
                ['qcm_id', $qcm->id],
                ['stagiaire_id', $stagiaire->id]
            ])->count();
        } else {
            $scoreCount = 0;
        }

        if ($scoreCount == 1) {
    
            return view('stagiaire.intranet.exercices.index', compact(['chapitre'], ['cours'], ['exercices']));
        } else {

            return redirect('/intranet/chapitre');
        }
    }

    public function nextIfExercice(Request $request) {
        $idUserAuth=null;
        $idUserRole=null;

        if(Auth::user()){

        $idUserAuth=Auth::user()->id;
        $idUserRole=Auth::user()->role_id;}
        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();
        if($stagiaire){
           $SuivreFormation = Suivre_formation::select('suivre_formations.*')
            ->join('sessions','sessions.id','suivre_formations.id_session')
            ->join('lier_sessions_stagiaires','lier_sessions_stagiaires.id_stagiaire','suivre_formations.id_stagiaire')
            ->where('suivre_formations.id_stagiaire', $stagiaire->id)
            ->where('lier_sessions_stagiaires.etat',1)
            ->where('sessions.etat',1)
            ->where('sessions.statut_id',3)->exists();
		}
		else {
		$SuivreFormation = false;
		}
        if(!$SuivreFormation){
            if($idUserRole==2)
            return redirect("/centre");
            else if($idUserRole==3)
            return redirect("/stagiaire");
            
            else if($idUserRole==4)
            
            return redirect("/formateur");
            else if($idUserRole==5)
            
            return redirect("/organisme");
            else
            return redirect("/");
        }

       

        $formation = Suivre_formation::select('suivre_formations.*')
        ->join('sessions','sessions.id','suivre_formations.id_session')->where('id_stagiaire', $stagiaire->id)->where('sessions.etat',1)->where('sessions.statut_id',3)->first();

        $chapitre = Chapitre::where('etat',1)->where('id_chapitre', $formation->id_chapitre)->first();

        $chapitreMax = Chapitre::where('etat',1)->where('id_cours', $formation->id_cours)->max('numero_chapitre');

        if ($chapitreMax != $chapitre->numero_chapitre) {
            $numeroChapitre = $chapitre->numero_chapitre+1;

            $nextChapitre = Chapitre::where([
                'id_cours' => $formation->id_cours,
                'numero_chapitre' => $numeroChapitre,
                'etat'=>1
            ])->first();
    
            Suivre_formation::join('sessions','sessions.id','suivre_formations.id_session')->where('id_stagiaire', $stagiaire->id)->where('sessions.etat',1)->where('sessions.statut_id',3)->update([
                'id_chapitre' => $nextChapitre->id_chapitre,
                'nombre_chapitre_lu' => $formation->nombre_chapitre_lu+1
            ]);
    
            return redirect('/intranet/chapitre');

        } else if($chapitreMax == $chapitre->numero_chapitre) {
           /* $coursActuel=FormationsContenirCours::where('id_cours',$formation->id_cours)->where('id_formation',$formation->id_formations)->first();
            $cours=FormationsContenirCours::where('id_formation',$formation->id_formations)->where('numero_cours','>',$coursActuel->numero_cours)->first();
if($cours){
    $nextChapitre = Chapitre::where('etat',1)->where('id_cours',$cours->id_cours)
    ->where('numero_chapitre',1)->first();
    

    Suivre_formation::join('sessions','sessions.id','suivre_formations.id_session')->where('id_stagiaire', $stagiaire->id)->where('sessions.etat',1)->where('sessions.statut_id',3)->update([
        'id_chapitre' => $nextChapitre->id_chapitre,
        'nombre_chapitre_lu' => $formation->nombre_chapitre_lu+1,
        'id_cours' => $cours->id_cours
    ]);

    return redirect('/intranet/chapitre');
}
else {*/
            $idUserAuth=null;
        $idUserRole=null;

            if(Auth::user()){

            $idUserAuth=Auth::user()->id;
        $idUserRole=Auth::user()->role_id;}
        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();
        if($stagiaire){
           $SuivreFormation = Suivre_formation::select('suivre_formations.*')
            ->join('sessions','sessions.id','suivre_formations.id_session')
            ->join('lier_sessions_stagiaires','lier_sessions_stagiaires.id_stagiaire','suivre_formations.id_stagiaire')
            ->where('suivre_formations.id_stagiaire', $stagiaire->id)
            ->where('lier_sessions_stagiaires.etat',1)
            ->where('sessions.etat',1)
            ->where('sessions.statut_id',3)->exists();
		}
		else {
		$SuivreFormation = false;
		}
        if(!$SuivreFormation){
            if($idUserRole==2)
            return redirect("/centre");
            else if($idUserRole==3)
            return redirect("/stagiaire");
            
            else if($idUserRole==4)
            
            return redirect("/formateur");
            else if($idUserRole==5)
            
            return redirect("/organisme");
            else
            return redirect("/");
        }

            

            $formation = Suivre_formation::select('suivre_formations.*')
            ->join('sessions','sessions.id','suivre_formations.id_session')->where('id_stagiaire', $stagiaire->id)->where('sessions.etat',1)->where('sessions.statut_id',3)->first();

            $projet = Projet::where('etat',1)->where('id_cours', $formation->id_cours)->first();

            $sessionStagiaire = Lier_sessions_stagiaire::where('id_stagiaire', $stagiaire->id)->where('id_session',$formation->id_session)->first();

            $session = Session::where('id', $sessionStagiaire->id_session)->first();

            $sessionProjet = Contenir_sessions_projet::where([
                ['id_session', '=' ,$session->id],
                ['id_projet','=', $projet->id]
            ])->first();

            if (date('Y-m-d') >= $sessionProjet->date_debut && date('Y-m-d') <= $sessionProjet->date_fin) {

                Contenir_sessions_projet::where([
                    ['id_session', '=' ,$session->id],
                    ['id_projet','=', $projet->id]
                ])->update([
                    'statut_id' => 3
                ]);
    
                return redirect('/intranet/projet');

            } else if(date('Y-m-d') < $sessionProjet->date_debut) {

                Contenir_sessions_projet::where([
                    ['id_session', '=' ,$session->id],
                    ['id_projet','=', $projet->id]
                ])->update([
                    'statut_id' => 1
                ]);

                return redirect('/intranet/projet');

            } else if(date('Y-m-d') > $sessionProjet->date_fin) {

                Contenir_sessions_projet::where([
                    ['id_session', '=' ,$session->id],
                    ['id_projet','=', $projet->id]
                ])->update([
                    'statut_id' => 4
                ]);

                return redirect('/intranet/projet');
            } 
       // }
    }
    }
    public function next(Request $request) {
        $idUserAuth=null;
        $idUserRole=null;

        if(Auth::user()){

        $idUserAuth=Auth::user()->id;
        $idUserRole=Auth::user()->role_id;
        }
        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();
        if($stagiaire){
           $SuivreFormation = Suivre_formation::select('suivre_formations.*')
            ->join('sessions','sessions.id','suivre_formations.id_session')
            ->join('lier_sessions_stagiaires','lier_sessions_stagiaires.id_stagiaire','suivre_formations.id_stagiaire')
            ->where('suivre_formations.id_stagiaire', $stagiaire->id)
            ->where('lier_sessions_stagiaires.etat',1)
            ->where('sessions.etat',1)
            ->where('sessions.statut_id',3)->exists();
		}
		else {
		$SuivreFormation = false;
		}
        if(!$SuivreFormation){
            if($idUserRole==2)
            return redirect("/centre");
            else if($idUserRole==3)
            return redirect("/stagiaire");
            
            else if($idUserRole==4)
            
            return redirect("/formateur");
            else if($idUserRole==5)
            
            return redirect("/organisme");
            else
            return redirect("/");
        }

        $exerciceCount = Exercice::where('etat',1)->where('id_chapitre', $request->get('id_chapitre'))->count();

       

        $formation = Suivre_formation::select('suivre_formations.*')
        ->join('sessions','sessions.id','suivre_formations.id_session')->where('id_stagiaire', $stagiaire->id)->where('sessions.etat',1)->where('sessions.statut_id',3)->first();

        $chapitre = Chapitre::where('etat',1)->where('id_chapitre', $formation->id_chapitre)->first();

        $chapitreMax = Chapitre::where('etat',1)->where('id_cours', $formation->id_cours)->max('numero_chapitre');

        if($exerciceCount >= 1) {

            return redirect('/intranet/exercice');

        } else if($chapitreMax == $chapitre->numero_chapitre) {
/*
            $coursActuel=FormationsContenirCours::where('id_cours',$formation->id_cours)->where('id_formation',$formation->id_formations)->first();
            $cours=FormationsContenirCours::where('id_formation',$formation->id_formations)->where('numero_cours','>',$coursActuel->numero_cours)->first();
            if($cours){
                $nextChapitre = Chapitre::where('etat',1)->where('id_cours',$cours->id_cours)
                ->where('numero_chapitre',1)->first();
                

                Suivre_formation::join('sessions','sessions.id','suivre_formations.id_session')->where('id_stagiaire', $stagiaire->id)->where('sessions.etat',1)->where('sessions.statut_id',3)->update([
                    'id_chapitre' => $nextChapitre->id_chapitre,
                    'nombre_chapitre_lu' => $formation->nombre_chapitre_lu+1,
                    'id_cours' => $cours->id_cours
                ]);

                return redirect('/intranet/chapitre');
            }
            else {
*/
            $formation = Suivre_formation::select('suivre_formations.*')
            ->join('sessions','sessions.id','suivre_formations.id_session')->where('id_stagiaire', $stagiaire->id)->where('sessions.etat',1)->where('sessions.statut_id',3)->first();

            $projet = Projet::where('etat',1)->where('id_cours', $formation->id_cours)->first();

            $sessionStagiaire = Lier_sessions_stagiaire::where('id_stagiaire', $stagiaire->id)->where('id_session',$formation->id_session)->first();

            $session = Session::where('id', $sessionStagiaire->id_session)->first();

            $sessionProjet = Contenir_sessions_projet::where([
                ['id_session', '=' ,$session->id],
                ['id_projet','=', $projet->id]
            ])->first();

            if (date('Y-m-d') >= $sessionProjet->date_debut && date('Y-m-d') <= $sessionProjet->date_fin) {

                Contenir_sessions_projet::where([
                    ['id_session', '=' ,$session->id],
                    ['id_projet','=', $projet->id]
                ])->update([
                    'statut_id' => 3
                ]);
    
                return redirect('/intranet/projet');

            } else if(date('Y-m-d') < $session->date_debut) {

                Contenir_sessions_projet::where([
                    ['id_session', '=' ,$session->id],
                    ['id_projet','=', $projet->id]
                ])->update([
                    'statut_id' => 1
                ]);

                return redirect('/intranet/projet');

            } else if(date('Y-m-d') > $session->date_fin) {

                Contenir_sessions_projet::where([
                    ['id_session', '=' ,$session->id],
                    ['id_projet','=', $projet->id]
                ])->update([
                    'statut_id' => 4
                ]);

                return redirect('/intranet/projet');
            } //}
        } else {

            $numeroChapitre = $chapitre->numero_chapitre+1;

            $nextChapitre = Chapitre::where([
                'id_cours' => $formation->id_cours,
                'numero_chapitre' => $numeroChapitre,
                'etat'=>1
            ])->first();

            Suivre_formation::join('sessions','sessions.id','suivre_formations.id_session')->where('id_stagiaire', $stagiaire->id)->where('sessions.etat',1)->where('sessions.statut_id',3)->update([
                'id_chapitre' => $nextChapitre->id_chapitre,
                'nombre_chapitre_lu' => $formation->nombre_chapitre_lu+1
            ]);
    
            return redirect('/intranet/chapitre');
        }
    }

    public function projet() {
        $idUserAuth=null;
        $idUserRole=null;

        if(Auth::user()){

        $idUserAuth=Auth::user()->id;
        $idUserRole=Auth::user()->role_id;}
        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();
        if($stagiaire){
           $SuivreFormation = Suivre_formation::select('suivre_formations.*')
            ->join('sessions','sessions.id','suivre_formations.id_session')
            ->join('lier_sessions_stagiaires','lier_sessions_stagiaires.id_stagiaire','suivre_formations.id_stagiaire')
            ->where('suivre_formations.id_stagiaire', $stagiaire->id)
            ->where('lier_sessions_stagiaires.etat',1)
            ->where('sessions.etat',1)
            ->where('sessions.statut_id',3)->exists();
		}
		else {
		$SuivreFormation = false;
		}
        if(!$SuivreFormation){
            if($idUserRole==2)
            return redirect("/centre");
            else if($idUserRole==3)
            return redirect("/stagiaire");
            
            else if($idUserRole==4)
            
            return redirect("/formateur");
            else if($idUserRole==5)
            
            return redirect("/organisme");
            else
            return redirect("/");
        }

        $formation = Suivre_formation::select('suivre_formations.*')
        ->join('sessions','sessions.id','suivre_formations.id_session')->where('id_stagiaire', $stagiaire->id)->where('sessions.etat',1)->where('sessions.statut_id',3)->first();

        $cours = Cours::where('etat',1)->where('id_cours', $formation->id_cours)->first();

        $projetCount = Projet::where('etat',1)->where('id_cours', $formation->id_cours)->count();

        $projet = Projet::where('etat',1)->where('id_cours', $formation->id_cours)->first();

        $FaireProjetCount = Faire_projet::where([
            ['id_stagiaire', '=' ,$stagiaire->id],
            ['id_projet','=', $projet->id]
        ])->count();

        if ($FaireProjetCount >= 1) {
            $faireProjet = true;
        } else {
            $faireProjet = false;
        }

        $sessionProjet = null;

        if ($projetCount == 1) {
            $projets = Projet::where('etat',1)->where('id_cours', $formation->id_cours)->with('Document')->get();

            $sessionStagiaire = Lier_sessions_stagiaire::where('id_stagiaire', $stagiaire->id)->where('id_session',$formation->id_session)->first();

            $session = Session::where('id', $sessionStagiaire->id_session)->first();

            $sessionProjet = Contenir_sessions_projet::where([
                ['id_session', '=', $session->id],
                ['id_projet','=', $projet->id]
            ])->first();

            return view('stagiaire.intranet.projet.index', compact(['projets'],['cours'],['formation'],['faireProjet'],['sessionProjet']));
        } else {
            return redirect('/intranet/chapitre');
        }
    }

    public function faireProjet(Request $request) {
        $idUserAuth=null;
        $idUserRole=null;

        if(Auth::user()){

        $idUserAuth=Auth::user()->id;
        $idUserRole=Auth::user()->role_id;}
        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();
        if($stagiaire){
           $SuivreFormation = Suivre_formation::select('suivre_formations.*')
            ->join('sessions','sessions.id','suivre_formations.id_session')
            ->join('lier_sessions_stagiaires','lier_sessions_stagiaires.id_stagiaire','suivre_formations.id_stagiaire')
            ->where('suivre_formations.id_stagiaire', $stagiaire->id)
            ->where('lier_sessions_stagiaires.etat',1)
            ->where('sessions.etat',1)
            ->where('sessions.statut_id',3)->exists();
		}
		else {
		$SuivreFormation = false;
		}
        if(!$SuivreFormation){
            if($idUserRole==2)
            return redirect("/centre");
            else if($idUserRole==3)
            return redirect("/stagiaire");
            
            else if($idUserRole==4)
            
            return redirect("/formateur");
            else if($idUserRole==5)
            
            return redirect("/organisme");
            else
            return redirect("/");
        }

       

        $formation = Suivre_formation::select('suivre_formations.*')
        ->join('sessions','sessions.id','suivre_formations.id_session')->where('id_stagiaire', $stagiaire->id)->where('sessions.etat',1)->where('sessions.statut_id',3)->first();

        $projet = Projet::where('etat',1)->where('id_cours', $formation->id_cours)->first();

        $FaireProjetCount = Faire_projet::where([
            ['id_stagiaire', '=' ,$stagiaire->id],
            ['id_projet','=', $projet->id]
        ])->count();

        if ($request->hasFile('lienDocProjet')) {
            $destinationPath = public_path('doc/faireProjet/');
            $file = $request->file('lienDocProjet');
            $filename = $file->getClientOriginalName();
            $lien = time().$filename;
            $file->move($destinationPath, $lien);
        } else {
            $lien = $request->get('lienProjet');
        }

        if ($FaireProjetCount < 1) {
            Faire_projet::create([
                'id_projet' => $projet->id,
                'id_stagiaire' => $stagiaire->id,
                'lien' => $lien
            ]);

            return redirect()->back()->with('success','Votre projet a bien été envoyé');
        } else {

            return redirect()->back()->with('fail','Votre projet a déjà été envoyé, vous ne pouvez pas en soumettre un autre');
        }
    }

    public function previousChapter() {
        $idUserAuth=null;
        $idUserRole=null;

        if(Auth::user()){

        $idUserAuth=Auth::user()->id;
        $idUserRole=Auth::user()->role_id;}
        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();
        if($stagiaire){
           $SuivreFormation = Suivre_formation::select('suivre_formations.*')
            ->join('sessions','sessions.id','suivre_formations.id_session')
            ->join('lier_sessions_stagiaires','lier_sessions_stagiaires.id_stagiaire','suivre_formations.id_stagiaire')
            ->where('suivre_formations.id_stagiaire', $stagiaire->id)
            ->where('lier_sessions_stagiaires.etat',1)
            ->where('sessions.etat',1)
            ->where('sessions.statut_id',3)->exists();
		}
		else {
		$SuivreFormation = false;
		}
        if(!$SuivreFormation){
            if($idUserRole==2)
            return redirect("/centre");
            else if($idUserRole==3)
            return redirect("/stagiaire");
            
            else if($idUserRole==4)
            
            return redirect("/formateur");
            else if($idUserRole==5)
            
            return redirect("/organisme");
            else
            return redirect("/");
        }



        $formation = Suivre_formation::select('suivre_formations.*')
        ->join('sessions','sessions.id','suivre_formations.id_session')->where('id_stagiaire', $stagiaire->id)->where('sessions.etat',1)->where('sessions.statut_id',3)->first();

        $maxCours = FormationsContenirCours::where('id_cours', $formation->id_cours)->first();

        $allCours = FormationsContenirCours::where('id_formation','=', $formation->id_formations)
        ->where('numero_cours','<=', $maxCours->numero_cours)
        ->with('Cours')->get();

        foreach ($allCours as $cour) {
            $chapitre = Chapitre::where('etat',1)->where('id_chapitre', $formation->id_chapitre)->first();
        }

        $arrayChap[] = $chapitre['numero_chapitre'];

        foreach($allCours as $cour) {
            $lessons[] = Cours::where('etat',1)->where('id_cours', $cour->id_cours)
            ->with('Chapitre', function ($query) use ($arrayChap, $cour, $formation) {
                if($cour->id_cours == $formation->id_cours) {
                    $query->where('numero_chapitre','<=', max($arrayChap))->where('id_cours', $cour->id_cours)->where('etat',1);
                } else {
                    $query->where('id_cours', $cour->id_cours)->where('etat',1);
                }
            })->get();
        }
        
        return view('stagiaire.intranet.cours.previousIndex', compact(['lessons']));
    }

    public function onePreviousChapter($id) {
        $chapitre = Chapitre::where('etat',1)->where('id_chapitre', $id)->with(['Section' => function($query) use($id) {
            $query->where('sections.id', $id);
        }])->first();

        return view('stagiaire.intranet.cours.onePreviousIndex', compact(['chapitre']));
    }

    public function previousQCM() {
        $idUserAuth=null;
        $idUserRole=null;

        if(Auth::user()){

        $idUserAuth=Auth::user()->id;
        $idUserRole=Auth::user()->role_id;}
        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();
        if($stagiaire){
           $SuivreFormation = Suivre_formation::select('suivre_formations.*')
            ->join('sessions','sessions.id','suivre_formations.id_session')
            ->join('lier_sessions_stagiaires','lier_sessions_stagiaires.id_stagiaire','suivre_formations.id_stagiaire')
            ->where('suivre_formations.id_stagiaire', $stagiaire->id)
            ->where('lier_sessions_stagiaires.etat',1)
            ->where('sessions.etat',1)
            ->where('sessions.statut_id',3)->exists();
		}
		else {
		$SuivreFormation = false;
		}
        if(!$SuivreFormation){
            if($idUserRole==2)
            return redirect("/centre");
            else if($idUserRole==3)
            return redirect("/stagiaire");
            
            else if($idUserRole==4)
            
            return redirect("/formateur");
            else if($idUserRole==5)
            
            return redirect("/organisme");
            else
            return redirect("/");
        }

       

        $formation = Suivre_formation::select('suivre_formations.*')
        ->join('sessions','sessions.id','suivre_formations.id_session')->where('id_stagiaire', $stagiaire->id)->where('sessions.etat',1)->where('sessions.statut_id',3)->first();

        $qcmScores = Score_qcm::select('score_qcm.*')
        ->join('lier_sessions_stagiaires','lier_sessions_stagiaires.id_stagiaire','score_qcm.stagiaire_id')
        ->join('sessions','sessions.id','lier_sessions_stagiaires.id_session')
        ->join('formations_contenir_cours','formations_contenir_cours.id_formation','sessions.formations_id')
        ->join('chapitres','chapitres.id_cours','formations_contenir_cours.id_cours')
        ->join('qcm', function($join)
                        {
                             $join->on('chapitres.id_chapitre', '=', 'qcm.id_chapitre');
                             $join->on('score_qcm.qcm_id','=','qcm.id');
                        }) 
        ->where('lier_sessions_stagiaires.id_session',$formation->id_session)
        ->where('score_qcm.stagiaire_id', $stagiaire->id)->get();
        
        if($qcmScores->count()!=0){
        foreach($qcmScores as $qcmScore) {
            $qcms[] = Qcm::where('etat',1)->where('id', $qcmScore->qcm_id)->with('Score_qcm')->get();
        }
    }
        else {
            $qcms = array();
        }
        return view('stagiaire.intranet.qcm.previousIndex', compact(['qcms']));
    }

    public function onePreviousQCM($id) {
        $qcm = Qcm::where('etat',1)->where('id', $id)->with(['Question_qcm' => function($query) use($id) {
            $query->where('question_qcm.qcm_id', $id)
            ->with('Reponse_question_qcm');
        }])->first();

        return view('stagiaire.intranet.qcm.onePreviousIndex', compact(['qcm']));
    }

    public function previousExercices() {
        $idUserAuth=null;
        $idUserRole=null;

        if(Auth::user()){

        $idUserAuth=Auth::user()->id;
        $idUserRole=Auth::user()->role_id;}
        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();
        if($stagiaire){
           $SuivreFormation = Suivre_formation::select('suivre_formations.*')
            ->join('sessions','sessions.id','suivre_formations.id_session')
            ->join('lier_sessions_stagiaires','lier_sessions_stagiaires.id_stagiaire','suivre_formations.id_stagiaire')
            ->where('suivre_formations.id_stagiaire', $stagiaire->id)
            ->where('lier_sessions_stagiaires.etat',1)
            ->where('sessions.etat',1)
            ->where('sessions.statut_id',3)->exists();
		}
		else {
		$SuivreFormation = false;
		}
        if(!$SuivreFormation){
            if($idUserRole==2)
            return redirect("/centre");
            else if($idUserRole==3)
            return redirect("/stagiaire");
            
            else if($idUserRole==4)
            
            return redirect("/formateur");
            else if($idUserRole==5)
            
            return redirect("/organisme");
            else
            return redirect("/");
        }

      

        $formation = Suivre_formation::select('suivre_formations.*')
        ->join('sessions','sessions.id','suivre_formations.id_session')->where('id_stagiaire', $stagiaire->id)->where('sessions.etat',1)->where('sessions.statut_id',3)->first();

        $maxCours = FormationsContenirCours::where('id_cours', $formation->id_cours)->first();

        $allCours = FormationsContenirCours::where('id_formation','=', $formation->id_formations)
        ->where('numero_cours','<=', $maxCours->numero_cours)
        ->with('Cours')->get();

        foreach ($allCours as $cour) {
            $chapitre = Chapitre::where('etat',1)->where('id_chapitre', $formation->id_chapitre)->first();
        }

        $arrayChap[] = $chapitre['numero_chapitre'];

        foreach($allCours as $cour) {
            $lessons[] = Cours::where('etat',1)->where('id_cours', $cour->id_cours)
            ->with('Chapitre', function ($query) use ($arrayChap, $cour, $formation) {
                if($cour->id_cours == $formation->id_cours) {
                    $query->where('numero_chapitre','<=', max($arrayChap))->where('id_cours', $cour->id_cours)->where('etat',1);
                } else {
                    $query->where('id_cours', $cour->id_cours)->where('etat',1);
                }
            })->get();
        }

        foreach($lessons as $lesson) {
            foreach($lesson as $l) {
                foreach($l->Chapitre as $chapitre) {
                    $chapitreIds[] = $chapitre->id_chapitre;
                }
            }
        }
        
        foreach($chapitreIds as $chapitreId) {
            $exercices[] = Exercice::where('etat',1)->where('id_chapitre', $chapitreId)->first();
        }

        return view('stagiaire.intranet.exercices.previousIndex', compact(['exercices']));
    }

    public function onePreviousExercice($id) {
        $exercice = Exercice::where('etat',1)->where('id', $id)->with(['Questions_exercice' => function($query) use($id) {
            $query->where('questions_exercices.exercice_id', $id)
            ->with('Questions_correction');
        }])->first();

        return view('stagiaire.intranet.exercices.onePreviousIndex', compact(['exercice']));
    }

    public function previousProjets() {
        $idUserAuth=null;
        $idUserRole=null;

        if(Auth::user()){

        $idUserAuth=Auth::user()->id;
        $idUserRole=Auth::user()->role_id;}
        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();
        if($stagiaire){
           $SuivreFormation = Suivre_formation::select('suivre_formations.*')
            ->join('sessions','sessions.id','suivre_formations.id_session')
            ->join('lier_sessions_stagiaires','lier_sessions_stagiaires.id_stagiaire','suivre_formations.id_stagiaire')
            ->where('suivre_formations.id_stagiaire', $stagiaire->id)
            ->where('lier_sessions_stagiaires.etat',1)
            ->where('sessions.etat',1)
            ->where('sessions.statut_id',3)->exists();
		}
		else {
		$SuivreFormation = false;
		}
        if(!$SuivreFormation){
            if($idUserRole==2)
            return redirect("/centre");
            else if($idUserRole==3)
            return redirect("/stagiaire");
            
            else if($idUserRole==4)
            
            return redirect("/formateur");
            else if($idUserRole==5)
            
            return redirect("/organisme");
            else
            return redirect("/");
        }


        $formation = Suivre_formation::select('suivre_formations.*')
        ->join('sessions','sessions.id','suivre_formations.id_session')->where('id_stagiaire', $stagiaire->id)->where('sessions.etat',1)->where('sessions.statut_id',3)->first();

        $sessionProjets = Contenir_sessions_projet::where('id_session', $formation->id_session)
        ->orWhere('statut_id', 3)->orWhere('statut_id', 4)->get();

        foreach($sessionProjets as $sessionProjet) {
            $projets[] = Projet::where('etat',1)->where('id', $sessionProjet->id_projet)->first();
        }

        return view('stagiaire.intranet.projet.previousIndex', compact(['projets']));
    }

    public function onePreviousProjet($id) {
        $projet = Projet::where('etat',1)->where('id', $id)->with('Document')->first();

        return view('stagiaire.intranet.projet.onePreviousIndex', compact(['projet']));
    }

    public function statutLive() {
        $idUserAuth=null;
        $idUserRole=null;

        if(Auth::user()){

        $idUserAuth=Auth::user()->id;
        $idUserRole=Auth::user()->role_id;}
        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();
        if($stagiaire){
           $SuivreFormation = Suivre_formation::select('suivre_formations.*')
            ->join('sessions','sessions.id','suivre_formations.id_session')
            ->join('lier_sessions_stagiaires','lier_sessions_stagiaires.id_stagiaire','suivre_formations.id_stagiaire')
            ->where('suivre_formations.id_stagiaire', $stagiaire->id)
            ->where('lier_sessions_stagiaires.etat',1)
            ->where('sessions.etat',1)
            ->where('sessions.statut_id',3)->exists();
		}
		else {
		$SuivreFormation = false;
		}
        if(!$SuivreFormation){
            if($idUserRole==2)
            return redirect("/centre");
            else if($idUserRole==3)
            return redirect("/stagiaire");
            
            else if($idUserRole==4)
            
            return redirect("/formateur");
            else if($idUserRole==5)
            
            return redirect("/organisme");
            else
            return redirect("/");
        }

       

        $formation = Suivre_formation::select('suivre_formations.*')
        ->join('sessions','sessions.id','suivre_formations.id_session')->where('id_stagiaire', $stagiaire->id)->where('sessions.etat',1)->where('sessions.statut_id',3)->first();

        $meeting = Participer_meeting::where('id_utilisateur', $idUserAuth)->count();
        
if($meeting !=0){
        $meeting = Participer_meeting::where('id_utilisateur', $idUserAuth)->first();
        $sessionLive = Meeting_en_ligne::where('id', $meeting->id_meeting)->where('id_cours', $formation->id_cours)->first();

        $endMeeting = date('Y-m-d H:i:s', strtotime($sessionLive->date_meeting.' +2 hours'));

        if(date('Y-m-d H:i:s') < $sessionLive->date_meeting) {

            $sessionLive->update([
                'statut_id' => 1
            ]);

            return redirect('/intranet/live');

        } else if(date('Y-m-d H:i:s') > $endMeeting) {

            $sessionLive->update([
                'statut_id' => 4
            ]);

            return redirect('/intranet/live');
        } else if(date('Y-m-d H:i:s') == $sessionLive->date_meeting || date('Y-m-d H:i:s') <= $endMeeting) {

        if($meeting != 0) {
            $meeting = Participer_meeting::where('id_utilisateur', $idUserAuth)->first();

            $sessionLive = Meeting_en_ligne::where('id', $meeting->id_meeting)->where('id_cours', $formation->id_cours)->first();
    
            $endMeeting = date('Y-m-d H:i:s', strtotime($sessionLive->date_meeting.' +2 hours'));
    
            if(date('Y-m-d H:i:s') < $sessionLive->date_meeting) {
    
                $sessionLive->update([
                    'statut_id' => 1
                ]);
    
                return redirect('/intranet/live');
    
            } else if(date('Y-m-d H:i:s') > $endMeeting) {
    
                $sessionLive->update([
                    'statut_id' => 4
                ]);
    
                return redirect('/intranet/live');
            } else if(date('Y-m-d H:i:s') >= $sessionLive->date_meeting && date('Y-m-d H:i:s') <= $endMeeting) {
    
                $sessionLive->update([
                    'statut_id' => 3
                ]);
    
                return redirect('/intranet/live');
            }
        } else {
            return redirect()->back()->with("warning","Pas de live prévu");
        }
    }
    }else {
        return redirect()->back()->with("warning","Pas de live prévu");
    }
    }
    public function live() {
        $idUserAuth=null;
        $idUserRole=null;

        if(Auth::user()){

        $idUserAuth=Auth::user()->id;
        $idUserRole=Auth::user()->role_id;}
        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();
        if($stagiaire){
           $SuivreFormation = Suivre_formation::select('suivre_formations.*')
            ->join('sessions','sessions.id','suivre_formations.id_session')
            ->join('lier_sessions_stagiaires','lier_sessions_stagiaires.id_stagiaire','suivre_formations.id_stagiaire')
            ->where('suivre_formations.id_stagiaire', $stagiaire->id)
            ->where('lier_sessions_stagiaires.etat',1)
            ->where('sessions.etat',1)
            ->where('sessions.statut_id',3)->exists();
		}
		else {
		$SuivreFormation = false;
		}
        if(!$SuivreFormation){
            if($idUserRole==2)
            return redirect("/centre");
            else if($idUserRole==3)
            return redirect("/stagiaire");
            
            else if($idUserRole==4)
            
            return redirect("/formateur");
            else if($idUserRole==5)
            
            return redirect("/organisme");
            else
            return redirect("/");
        }


        $formation = Suivre_formation::select('suivre_formations.*')
        ->join('sessions','sessions.id','suivre_formations.id_session')->where('id_stagiaire', $stagiaire->id)->where('sessions.etat',1)->where('sessions.statut_id',3)->first();

        $meeting = Participer_meeting::where('id_utilisateur', $idUserAuth)->count();
        $sessionLive = null;
        if($meeting !=0){
            $meeting = Participer_meeting::where('id_utilisateur', $idUserAuth)->first();
        $sessionLive = Meeting_en_ligne::where('id', $meeting->id_meeting)->where('id_cours', $formation->id_cours)->first();

        return view('stagiaire.intranet.live.index', compact(['sessionLive']));
        }else {
            return redirect()->back()->with("warning","Pas de live prévu");
        }
    }
}