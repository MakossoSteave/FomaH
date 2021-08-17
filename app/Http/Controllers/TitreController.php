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
use App\Models\Titre;
use Illuminate\Support\Facades\Storage;
use PDF;
class TitreController extends Controller
{
    public function index()
    {
        $titres = Titre::select('titres.*','stagiaires.nom','stagiaires.prenom','sessions.id as sessionID')
        ->join('stagiaires','stagiaires.id','titres.stagiaire_id')
        ->leftJoin('sessions','sessions.id','titres.session_id')
        ->orderBy('updated_at','desc')->paginate(8)->setPath('titre');          
        return view('admin.titre.index',compact(['titres']));
    }
    public function destroy($id)
    {   $titre = Titre::find($id);
        if($titre){
            Titre::where('id',$id)->delete();
            $stagiaire = Stagiaire::find($titre->stagiaire_id);
            Storage::delete("session/$titre->session_id/diplome/$stagiaire->prenom $stagiaire->nom diplome.pdf");
            return redirect()->back()->with('success','Titre supprimé avec succès');

            //"session/$idSession/diplome/$stagiaire->prenom $stagiaire->nom diplome.pdf"
        }
        else {
            return redirect()->back()->with('error','Titre non trouvé');
        }
       
    }
}
