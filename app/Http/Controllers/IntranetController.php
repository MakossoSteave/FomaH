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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IntranetController extends Controller
{
    public function index(){
        
        $idUserAuth=null;

        if(Auth::user())

        $idUserAuth=Auth::user()->id;

        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();
        
        $countFormation = Suivre_formation::where('id_stagiaire', $stagiaire->id)->count();
       
        $formationName = null;

        $sommaire = null;

        $session = null;

        if ($countFormation == 1) {
            $formation = Suivre_formation::where('id_stagiaire', $stagiaire->id)->first();
       
            $sessionStagiaire = Lier_sessions_stagiaire::where('id_stagiaire', $stagiaire->id)->first();

            $session = Session::where('id', $sessionStagiaire->id_session)->first();

            $formation = Suivre_formation::where('id_stagiaire', $stagiaire->id)->first();

            $formationName = Formation::where('id', $formation->id_formations)->first();

            $sommaire = FormationsContenirCours::where('id_formation', $formation->id_formations)->with('Cours.Chapitre.Section')->orderby('numero_cours', 'ASC')->get();
            
        }

        return view('stagiaire.intranet.index', compact(['sommaire'], ['formationName'], ['session']));
    }

    public function preIndex() {
        $idUserAuth=null;

        if(Auth::user())

        $idUserAuth=Auth::user()->id;

        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();
        
        $countFormation = Suivre_formation::where('id_stagiaire', $stagiaire->id)->count();
        
        $sessionStagiaire = Lier_sessions_stagiaire::where('id_stagiaire', $stagiaire->id)->first();

        if($sessionStagiaire){
            $session = Session::where('id', $sessionStagiaire->id_session)->first();
        } else {
            $session=null;
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

    public function chapitre() {
        $idUserAuth=null;

        if(Auth::user())

        $idUserAuth=Auth::user()->id;

        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();
        
        $countFormation = Suivre_formation::where('id_stagiaire', $stagiaire->id)->count();

        $qcmCount = 0;

        $scoreCount = 0;

        $exerciceCount = 0;

        $projetCount = 0;

        $cours = null;

        $chapitre = null;

        if ($countFormation == 1) {
            $formation = Suivre_formation::where('id_stagiaire', $stagiaire->id)->first();

            $qcmCount = Qcm::where('id_chapitre', $formation->id_chapitre)->where('etat',1)->count();

            $cours = Cours::where('id_cours', $formation->id_cours)->first();

            $chapitre = Suivre_formation::where('id_chapitre', $formation->id_chapitre)->with('Chapitre.Section')->first();

            $qcm = Qcm::where('id_chapitre', $formation->id_chapitre)->where('etat',1)->first();
    
            $scoreCount = Score_qcm::where([
                ['qcm_id', $qcm->id],
                ['stagiaire_id', $stagiaire->id]
                ])->count();
                
            $exerciceCount = Exercice::where('id_chapitre', $formation->id_chapitre)->count();

            $chapitreMax = Chapitre::where('id_cours', $formation->id_cours)->max('numero_chapitre');

            $chap = Chapitre::where('id_chapitre', $formation->id_chapitre)->first();

            if($chapitreMax == $chap->numero_chapitre) {
                $projetCount = Projet::where('id_cours', $formation->id_cours)->count();
            }
        }

        return view('stagiaire.intranet.cours.index', compact(['chapitre'], ['cours'],['qcmCount'],['scoreCount'],['exerciceCount'],['projetCount']));
    }

    public function qcm() {
        $idUserAuth=null;

        if(Auth::user())

        $idUserAuth=Auth::user()->id;

        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();
        
        $formation = Suivre_formation::where('id_stagiaire', $stagiaire->id)->first();

        $cours = Cours::where('id_cours', $formation->id_cours)->first();

        $qcms = Qcm::where('id_chapitre', $formation->id_chapitre)->where('etat',1)->with('Question_qcm.Reponse_question_qcm')->get();

        $qcm = Qcm::where('id_chapitre', $formation->id_chapitre)->where('etat',1)->first();
    
        $scoreCount = Score_qcm::where('qcm_id', $qcm->id)->count();
       
        $score = null;

        if ($scoreCount == 1) {
            $score = Score_qcm::where('qcm_id', $qcm->id)->first();
        }

        return view('stagiaire.intranet.qcm.index', compact(['qcms'],['cours'],['formation'],['score']));
    }

    public function score(Request $request) {
        $idUserAuth=null;

        if(Auth::user())

        $idUserAuth=Auth::user()->id;

        $resultat = 0;

        for ($idRadio=0; $idRadio < count($request->get('reponseNameRadio')); $idRadio++) { 

            if($request->reponseNameRadio[$idRadio] == 1) {
                $resultat = $resultat+1;
            }
        }

        do {
            $idScore = rand(10000000, 99999999);
        } while(Score_qcm::find($idScore) != null);

        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();

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

        if(Auth::user())

        $idUserAuth=Auth::user()->id;

        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();

        $formation = Suivre_formation::where('id_stagiaire', $stagiaire->id)->first();

        $cours = Cours::where('id_cours', $formation->id_cours)->first();

        $chapitre = Chapitre::where('id_chapitre', $formation->id_chapitre)->first();

        $exercices = Exercice::where('id_chapitre', $formation->id_chapitre)->with('Questions_exercice.Questions_correction')->get();

        $qcm = Qcm::where('id_chapitre', $formation->id_chapitre)->first();

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

        if(Auth::user())

        $idUserAuth=Auth::user()->id;

        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();

        $formation = Suivre_formation::where('id_stagiaire', $stagiaire->id)->first();

        $chapitre = Chapitre::where('id_chapitre', $formation->id_chapitre)->first();

        $chapitreMax = Chapitre::where('id_cours', $formation->id_cours)->max('numero_chapitre');

        if ($chapitreMax != $chapitre->numero_chapitre) {
            $numeroChapitre = $chapitre->numero_chapitre+1;

            $nextChapitre = Chapitre::where([
                'id_cours' => $formation->id_cours,
                'numero_chapitre' => $numeroChapitre
            ])->first();
    
            Suivre_formation::where('id_stagiaire', $stagiaire->id)->update([
                'id_chapitre' => $nextChapitre->id_chapitre
            ]);
    
            return redirect('/intranet/chapitre');

        } else if($chapitreMax == $chapitre->numero_chapitre) {

            $idUserAuth=null;

            if(Auth::user())

            $idUserAuth=Auth::user()->id;

            $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();

            $formation = Suivre_formation::where('id_stagiaire', $stagiaire->id)->first();

            $projet = Projet::where('id_cours', $formation->id_cours)->first();

            $sessionStagiaire = Lier_sessions_stagiaire::where('id_stagiaire', $stagiaire->id)->first();

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
        }
    }

    public function next(Request $request) {
        $idUserAuth=null;

        if(Auth::user())

        $idUserAuth=Auth::user()->id;

        $exerciceCount = Exercice::where('id_chapitre', $request->get('id_chapitre'))->count();

        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();

        $formation = Suivre_formation::where('id_stagiaire', $stagiaire->id)->first();

        $chapitre = Chapitre::where('id_chapitre', $formation->id_chapitre)->first();

        $chapitreMax = Chapitre::where('id_cours', $formation->id_cours)->max('numero_chapitre');

        if($exerciceCount >= 1) {

            return redirect('/intranet/exercice');

        } else if($chapitreMax == $chapitre->numero_chapitre) {

            $idUserAuth=null;

            if(Auth::user())

            $idUserAuth=Auth::user()->id;

            $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();

            $formation = Suivre_formation::where('id_stagiaire', $stagiaire->id)->first();

            $projet = Projet::where('id_cours', $formation->id_cours)->first();

            $sessionStagiaire = Lier_sessions_stagiaire::where('id_stagiaire', $stagiaire->id)->first();

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
            } 
        } else {

            $numeroChapitre = $chapitre->numero_chapitre+1;

            $nextChapitre = Chapitre::where([
                'id_cours' => $formation->id_cours,
                'numero_chapitre' => $numeroChapitre
            ])->first();

            Suivre_formation::where('id_stagiaire', $stagiaire->id)->update([
                'id_chapitre' => $nextChapitre->id_chapitre
            ]);
    
            return redirect('/intranet/chapitre');
        }
    }

    public function projet() {
        $idUserAuth=null;

        if(Auth::user())

        $idUserAuth=Auth::user()->id;

        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();

        $formation = Suivre_formation::where('id_stagiaire', $stagiaire->id)->first();

        $cours = Cours::where('id_cours', $formation->id_cours)->first();

        $projetCount = Projet::where('id_cours', $formation->id_cours)->count();

        $projet = Projet::where('id_cours', $formation->id_cours)->first();

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
            $projets = Projet::where('id_cours', $formation->id_cours)->with('Document')->get();

            $sessionStagiaire = Lier_sessions_stagiaire::where('id_stagiaire', $stagiaire->id)->first();

            $session = Session::where('id', $sessionStagiaire->id_session)->first();

            $sessionProjet = Contenir_sessions_projet::where([
                ['id_session', '=' ,$session->id],
                ['id_projet','=', $projet->id]
            ])->first();

            return view('stagiaire.intranet.projet.index', compact(['projets'],['cours'],['formation'],['faireProjet'],['sessionProjet']));
        } else {
            return redirect('/intranet/chapitre');
        }
    }

    public function faireProjet(Request $request) {
        $idUserAuth=null;

        if(Auth::user())

        $idUserAuth=Auth::user()->id;

        $stagiaire = Stagiaire::where('user_id', $idUserAuth)->first();

        $formation = Suivre_formation::where('id_stagiaire', $stagiaire->id)->first();

        $projet = Projet::where('id_cours', $formation->id_cours)->first();

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

    public function live() {

    }

    public function previousChapitre() {

    }

    public function previousProjets() {

    }

    public function previousQCM() {

    }

    public function previousExercices() {

    }
}