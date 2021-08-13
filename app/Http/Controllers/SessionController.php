<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Session;
use App\Models\Formateur;
use App\Models\Formation;
use App\Models\Statut;

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
         'formation_id' => ['required'],
         'statut_id' => ['required']
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
            'statut_id' => $request->get('statut_id')
        ]);
       
        return redirect('/session')->with('success','Session créé avec succès');
    }

    public function etat($id)
    {
        $session = Session::find($id);
        $etat = !$session->etat;

        Session::where('id', $id)->update(array('etat' => $etat));
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'date_debut' => ['required'],
            'date_fin' => ['required'],
            'etat' => ['required'],
            'formation_id' => ['required'],
            'statut_id' => ['required']
        ]);

        Session::where('id', $id)->update([
            'date_debut' => $request->get('date_debut'),
            'date_fin' => $request->get('date_fin'),
            'etat' => $request->get('etat'),
            'formateur_id' => $request->get('formateur_id'),
            'formations_id' => $request->get('formation_id'),
            'statut_id' => $request->get('statut_id')
        ]);

        return redirect('/session')->with('success','Session modifié avec succès');
    }

    public function destroy($id)
    {
        Session::where('id',$id)->delete();

        return redirect('/session')->with('success','Session supprimé avec succès');
    }
}
