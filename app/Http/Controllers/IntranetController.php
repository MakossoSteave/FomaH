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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IntranetController extends Controller
{
    public function index(){
        $stagiaire = Stagiaire::where('user_id', Auth::user()->id)->first();
        
        $countFormation = Suivre_formation::where('id_stagiaire', $stagiaire->id)->count();

        if ($countFormation == 1) {
            $formation = Suivre_formation::where('id_stagiaire', $stagiaire->id)->first();

            $formationName = Formation::where('id', $formation->id_formations)->first();

            $sommaire = FormationsContenirCours::where('id_formation', $formation->id_formations)->with('Cours.Chapitre.Section')->orderby('numero_cours', 'ASC')->get();
        }

        return view('stagiaire.intranet.index', compact(['sommaire'], ['formationName']));
    }

    public function chapitre() {
        $stagiaire = Stagiaire::where('user_id', Auth::user()->id)->first();
        
        $countFormation = Suivre_formation::where('id_stagiaire', $stagiaire->id)->count();

        if ($countFormation == 1) {
            $formation = Suivre_formation::where('id_stagiaire', $stagiaire->id)->first();

            $cours = Cours::where('id_cours', $formation->id_cours)->first();
            $chapitre = Suivre_formation::where('id_chapitre', $formation->id_chapitre)->with('Chapitre.Section')->first();
        }

        return view('stagiaire.intranet.cours.index', compact(['chapitre'], ['cours']));
    }

    public function qcm() {
        $stagiaire = Stagiaire::where('user_id', Auth::user()->id)->first();
        
        $formation = Suivre_formation::where('id_stagiaire', $stagiaire->id)->first();

        $cours = Cours::where('id_cours', $formation->id_cours)->first();

        $qcms = Qcm::where('id_chapitre', $formation->id_chapitre)->with('Question_qcm.Reponse_question_qcm')->get();

        $qcm = Qcm::where('id_chapitre', $formation->id_chapitre)->first();

        $scoreCount = Score_qcm::where('qcm_id', $qcm->id)->count();

        $score = null;

        if ($scoreCount == 1) {
            $score = Score_qcm::where('qcm_id', $qcm->id)->first();
        }

        return view('stagiaire.intranet.qcm.index', compact(['qcms'],['cours'],['formation'],['score']));
    }

    public function score(Request $request) {

        $resultat = 0;

        for ($idRadio=0; $idRadio < count($request->get('reponseNameRadio')); $idRadio++) { 

            if($request->reponseNameRadio[$idRadio] == 1) {
                $resultat = $resultat+1;
            }
        }

        do {
            $idScore = rand(10000000, 99999999);
        } while(Score_qcm::find($idScore) != null);

        $stagiaire = Stagiaire::where('user_id', Auth::user()->id)->first();

        Score_qcm::create([
            'id' => $idScore,
            'resultat' => ($resultat/count($request->get('reponseNameRadio')))*100,
            'stagiaire_id' => $stagiaire->id,
            'qcm_id' => $request->get('qcm_id')
        ]);

        return redirect('/intranet/qcm');
    }

    public function exercice() {

        $stagiaire = Stagiaire::where('user_id', Auth::user()->id)->first();

        $formation = Suivre_formation::where('id_stagiaire', $stagiaire->id)->first();

        $cours = Cours::where('id_cours', $formation->id_cours)->first();

        $chapitre = Chapitre::where('id_chapitre', $formation->id_chapitre)->first();

        $exercices = Exercice::where('id_chapitre', $formation->id_chapitre)->with('Questions_exercice.Questions_correction')->get();

        $qcm = Qcm::where('id_chapitre', $formation->id_chapitre)->first();

        $scoreCount = Score_qcm::where('qcm_id', $qcm->id)->count();

        $chapitreMax = Chapitre::where('id_cours', $formation->id_cours)->max('numero_chapitre');

        if ($scoreCount == 1 && $chapitreMax != $chapitre->numero_chapitre) {
            $numeroChapitre = $chapitre->numero_chapitre+1;

            $nextChapitre = Chapitre::where([
                'id_cours' => $formation->id_cours,
                'numero_chapitre' => $numeroChapitre
            ])->first();
    
            Suivre_formation::where('id_stagiaire', $stagiaire->id)->update([
                'id_chapitre' => $nextChapitre->id_chapitre
            ]);
    
            return view('stagiaire.intranet.exercices.index', compact(['chapitre'], ['cours'], ['exercices']));
        }  else if($chapitreMax == $chapitre->numero_chapitre) {
            return redirect('intranet/projet');
        } else {

            return redirect('/intranet/chapitre');
        }
    }

    public function next(Request $request) {
        $exerciceCount = Exercice::where('id_chapitre', $request->get('id_chapitre'))->count();

        $stagiaire = Stagiaire::where('user_id', Auth::user()->id)->first();

        $formation = Suivre_formation::where('id_stagiaire', $stagiaire->id)->first();

        $chapitre = Chapitre::where('id_chapitre', $formation->id_chapitre)->first();

        $chapitreMax = Chapitre::where('id_cours', $formation->id_cours)->max('numero_chapitre');

        if($exerciceCount >= 1) {
            return redirect('/intranet/exercice');
        } else if($chapitreMax == $chapitre->numero_chapitre) {
            return redirect('/intranet/projet');
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

    public function projet(Request $request) {

        $stagiaire = Stagiaire::where('user_id', Auth::user()->id)->first();

        $formation = Suivre_formation::where('id_stagiaire', $stagiaire->id)->first();

        $cours = Cours::where('id_cours', $formation->id_cours)->first();

        $projetCount = Projet::where('id_cours', $formation->id_cours)->count();

        if ($projetCount == 1) {
            $projets = Projet::where('id_cours', $formation->id_cours)->with('Document')->get();

            return view('stagiaire.intranet.projet.index', compact(['projets'],['cours'],['formation']));
        } else {
            return redirect('/intranet/chapitre');
        }
    }
}