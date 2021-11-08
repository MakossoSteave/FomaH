<?php

namespace App\Http\Controllers;

use App\Models\Suivre_formation;
use App\Models\FormationsContenirCours;
use App\Models\Stagiaire;
use App\Models\Formateur;
use App\Models\Cours;
use App\Models\Qcm;
use App\Models\Score_qcm;
use App\Models\Exercice;
use App\Models\Chapitre;
use App\Models\Projet;
use App\Models\Session;
use App\Models\Titre;
use App\Models\Lier_sessions_stagiaire;
use App\Models\Faire_projet;
use App\Models\Contenir_sessions_projet;
use App\Models\Participer_meeting;
use App\Models\Meeting_en_ligne;
use App\Rules\FilenameDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class IntranetFormateurController extends Controller
{
    public function index()
    {
        $idUserAuth=null;
        $idUserRole=null;

        if(Auth::user()){

        $idUserAuth=Auth::user()->id;
        $idUserRole=Auth::user()->role_id;

        $formateur = Formateur::where('user_id', $idUserAuth)->first();

        if($formateur){
           $formateurSuivreFormation = Suivre_formation::select('suivre_formations.*')
            ->join('sessions','sessions.id','suivre_formations.id_session')
            ->where('sessions.formateur_id', $formateur->id)
            ->where('sessions.etat',1)
            ->where('sessions.statut_id',3)->exists();
		}
		else {
            $formateurSuivreFormation = false;
            }
            if(!$formateurSuivreFormation){
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
            } else {

                $formateurFormations = Suivre_formation::join('sessions','sessions.id','suivre_formations.id_session')
                ->join('formations', 'formations.id', 'suivre_formations.id_formations')
                ->join('stagiaires', 'stagiaires.id', 'suivre_formations.id_stagiaire')
                ->select(
                    'suivre_formations.*',
                    'sessions.*',
                    'formations.libelle',
                    'stagiaires.nom',
                    'stagiaires.prenom'
                )
                ->where('sessions.formateur_id', $formateur->id)
                ->where('stagiaires.formateur_id', $formateur->id)
                ->where('sessions.etat',1)
                ->where('sessions.statut_id',3)
                ->get();

                return view('formateur.intranet.index', compact('formateurFormations'));
            }

        }
        
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }


    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
