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
use App\Models\User;
use App\Rules\FilenameDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

date_default_timezone_set('Europe/Paris');

class IntranetFormateurController extends Controller
{
    public function index()
    {
        $idUserAuth = null;
        $idUserRole = null;

        if (Auth::user()) {

            $idUserAuth = Auth::user()->id;
            $idUserRole = Auth::user()->role_id;

            $formateur = Formateur::where('user_id', $idUserAuth)->first();

            if ($formateur) {
                $formateurSuivreFormation = Suivre_formation::select('suivre_formations.*')
                    ->join('sessions', 'sessions.id', 'suivre_formations.id_session')
                    ->where('sessions.formateur_id', $formateur->id)
                    ->where('sessions.etat', 1)
                    ->where('sessions.statut_id', 3)->exists();
            } else {
                $formateurSuivreFormation = false;
            }
            if (!$formateurSuivreFormation) {
                switch ($idUserRole) {
                    case 2:
                        return redirect("/centre");
                        break;
                    case 3:
                        return redirect("/stagiaire");
                        break;
                    case 4:
                        return redirect("/formateur");
                        break;
                    case 5:
                        return redirect("/organisme");
                        break;
                    default:
                        return redirect("/");
                        break;
                }
            } else {

                $formateurFormations = Suivre_formation::join('sessions', 'sessions.id', 'suivre_formations.id_session')
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
                    ->where('sessions.etat', 1)
                    ->where('sessions.statut_id', 3)
                    ->get();

                return view('formateur.intranet.index', compact('formateurFormations'));
            }
        }
    }

    public function projet()
    {
        $idUserAuth = null;
        $idUserRole = null;

        if (Auth::user()) {

            $idUserAuth = Auth::user()->id;
            $idUserRole = Auth::user()->role_id;

            $formateurSuivreFormation = true;

            $projetList = null;

            $formateur = Formateur::where('user_id', $idUserAuth)->first();

            if ($formateur) {
                $formateurSuivreFormation = Suivre_formation::select('suivre_formations.*')
                ->join('sessions', 'sessions.id', 'suivre_formations.id_session')
                ->where('sessions.formateur_id', $formateur->id)
                ->where('sessions.etat', 1)
                ->where('sessions.statut_id', 3)->exists();

                $projetList = Projet::where('projets.formateur_id', $formateur->id)
                    ->join('faire_projets', 'faire_projets.id_projet', 'projets.id')
                    ->join('contenir_sessions_projets', 'contenir_sessions_projets.id_projet', 'projets.id')
                    ->join('stagiaires', 'stagiaires.id', 'faire_projets.id_stagiaire')
                    ->where('contenir_sessions_projets.date_fin' ,'>', date('Y-m-d'))
                    ->get();

            } else {
                $formateurSuivreFormation = false;
            }
            
            if (!$formateurSuivreFormation) {
                switch ($idUserRole) {
                    case 2:
                        return redirect("/centre");
                        break;
                    case 3:
                        return redirect("/stagiaire");
                        break;
                    case 4:
                        return redirect("/formateur");
                        break;
                    case 5:
                        return redirect("/organisme");
                        break;
                    default:
                        return redirect("/");
                        break;
                }
            } else {

                return view('formateur.intranet.projet.index', compact('projetList'));
            }
        }
    }

    public function oneProjet($id)
    {
        $idUserAuth = null;
        $idUserRole = null;

        if (Auth::user()) {

            $idUserAuth = Auth::user()->id;
            $idUserRole = Auth::user()->role_id;

            $formateurSuivreFormation = true;

            $projet = null;

            $formateur = Formateur::where('user_id', $idUserAuth)->first();

            if ($formateur) {
                $formateurSuivreFormation = Suivre_formation::select('suivre_formations.*')
                ->join('sessions', 'sessions.id', 'suivre_formations.id_session')
                ->where('sessions.formateur_id', $formateur->id)
                ->where('sessions.etat', 1)
                ->where('sessions.statut_id', 3)->exists();

                $projet = Projet::where('projets.formateur_id', $formateur->id)
                    ->join('faire_projets', 'faire_projets.id_projet', 'projets.id')
                    ->join('contenir_sessions_projets', 'contenir_sessions_projets.id_projet', 'projets.id')
                    ->where('faire_projets.id_stagiaire', $id)
                    ->where('contenir_sessions_projets.date_fin' ,'>', date('Y-m-d'))
                    ->with('Document')
                    ->first();

            } else {
                $formateurSuivreFormation = false;
            }
            
            if (!$formateurSuivreFormation) {
                switch ($idUserRole) {
                    case 2:
                        return redirect("/centre");
                        break;
                    case 3:
                        return redirect("/stagiaire");
                        break;
                    case 4:
                        return redirect("/formateur");
                        break;
                    case 5:
                        return redirect("/organisme");
                        break;
                    default:
                        return redirect("/");
                        break;
                }
            } else {

                return view('formateur.intranet.projet.detail', compact('projet'));
            }
        }
    }

    public function projetGrade(Request $request)
    {
        $idUserAuth = null;
        $idUserRole = null;

        if (Auth::user()) {

            $idUserAuth = Auth::user()->id;
            $idUserRole = Auth::user()->role_id;

            $formateur = Formateur::where('user_id', $idUserAuth)->first();

            if ($formateur) {
                $formateurSuivreFormation = Suivre_formation::select('suivre_formations.*')
                ->join('sessions', 'sessions.id', 'suivre_formations.id_session')
                ->where('sessions.formateur_id', $formateur->id)
                ->where('sessions.etat', 1)
                ->where('sessions.statut_id', 3)->exists();

                $request->validate([

                ]);
        
                Faire_projet::where('id_stagiaire', $_POST['stagiaire_id'])
                ->where('id_projet', $_POST['projet_id'])
                ->update([
                    'statut_reussite' => $request->get('statut_reussite'),
                    'resultat_description' => $request->get('resultat_description')
                ]);
                
            } else {
                $formateurSuivreFormation = false;
            }
            
            if (!$formateurSuivreFormation) {
                switch ($idUserRole) {
                    case 2:
                        return redirect("/centre");
                        break;
                    case 3:
                        return redirect("/stagiaire");
                        break;
                    case 4:
                        return redirect("/formateur");
                        break;
                    case 5:
                        return redirect("/organisme");
                        break;
                    default:
                        return redirect("/");
                        break;
                }
            } else {

                return redirect("/intranet/formateurs/projet/".$_POST['stagiaire_id']."?name=".$_POST['name']);
            }
        }
    }

    public function live()
    {
        $idUserAuth = null;
        $idUserRole = null;

        if (Auth::user()) {

            $idUserAuth = Auth::user()->id;
            $idUserRole = Auth::user()->role_id;

            $user = User::where('id', $idUserAuth)->first();

            if ($user) {
                $lives = Meeting_en_ligne::where('user_id', $idUserAuth)->exists();
            } else {
                $lives = false;
            }
            if (!$lives) {
                switch ($idUserRole) {
                    case 2:
                        return redirect("/centre");
                        break;
                    case 3:
                        return redirect("/stagiaire");
                        break;
                    case 4:
                        return redirect("/formateur");
                        break;
                    case 5:
                        return redirect("/organisme");
                        break;
                    default:
                        return redirect("/");
                        break;
                }
            } else {
                $lives = Meeting_en_ligne::where('user_id', $idUserAuth)
                    ->where('statut_id', '=', '2')
                    ->orWhere('statut_id', '=', '3')
                    ->orderby('date_meeting')
                    ->get();

                $participants = Meeting_en_ligne::where('user_id', $idUserAuth)
                    ->join('participer_meetings', 'participer_meetings.id_meeting', 'meeting_en_lignes.id')
                    ->join('users', 'users.id', 'participer_meetings.id_utilisateur')
                    ->where('statut_id', '=', '2')
                    ->orWhere('statut_id', '=', '3')
                    ->get();

                return view('formateur.intranet.lives.index', compact(['lives', 'participants']));
            }
        } else {
            switch ($idUserRole) {
                case 2:
                    return redirect("/centre");
                    break;
                case 3:
                    return redirect("/stagiaire");
                    break;
                case 4:
                    return redirect("/formateur");
                    break;
                case 5:
                    return redirect("/organisme");
                    break;
                default:
                    return redirect("/");
                    break;
            }
        }
    }

    public function createLive(Request $request)
    {
        $idUserAuth = Auth::user()->id;

        $request->validate([
            'date_meeting' => 'required',
            'lien' => 'required'
           ]);
           do {
               $id = rand(10000000, 99999999);
           } while(Meeting_en_ligne::find($id)!=null);
   
           Meeting_en_ligne::create(
               $request->all() + 
               ['id'=> $id] + 
               ['user_id' => $idUserAuth] + 
               ['id_cours' => 22043240] + 
               ['statut_id' => 2]
            );

           return redirect('/intranet/formateurs/lives')->with('success','Create Successfully');
    }

    public function deleteLive(Request $request)
    {

    }

    public function score()
    {
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
