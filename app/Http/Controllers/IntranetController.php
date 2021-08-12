<?php

namespace App\Http\Controllers;

use App\Models\Suivre_formation;
use App\Models\FormationsContenirCours;
use App\Models\Stagiaire;
use App\Models\Formation;
use App\Models\Cours;
use App\Models\Chapitre;

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

    public function cours() {
        $stagiaire = Stagiaire::where('user_id', Auth::user()->id)->first();
        
        $countFormation = Suivre_formation::where('id_stagiaire', $stagiaire->id)->count();

        if ($countFormation == 1) {
            $formation = Suivre_formation::where('id_stagiaire', $stagiaire->id)->first();

            $cours = Cours::where('id_cours', $formation->id_cours)->first();
            $chapitre = Suivre_formation::where('id_chapitre', $formation->id_chapitre)->with('Chapitre.Section')->first();
        }
        return view('stagiaire.intranet.cours.index', compact(['chapitre'], ['cours']));
    }
}