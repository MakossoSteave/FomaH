<?php

namespace App\Http\Controllers;

use App\Models\Suivre_formation;
use App\Models\FormationsContenirCours;
use App\Models\Stagiaire;
use App\Models\Formation;
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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

date_default_timezone_set('Europe/Paris');

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
           $sessionFormateur = Suivre_formation::select('suivre_formations.*')
            ->join('sessions','sessions.id','suivre_formations.id_session')
            ->where('sessions.formateur_id', $formateur->id)
            ->where('sessions.statut_id',3)
            ->get();
		} else {
		    $sessionFormateur = false;
		}
        
        if (!$sessionFormateur) {
            switch ($idUserRole) {
                case '2':
                    return redirect("/centre");
                    break;
                case '3':
                    return redirect("/stagiaire");
                    break;
                case '4':
                    return redirect("/formateur");
                    break;
                case '5':
                    return redirect("/organisme");
                    break;
                default:
                return redirect("/");
                    break;
            }
        }
            return view('formateur.intranet.index', compact(['sessionFormateur']));
        } else {
            return redirect("/");
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
