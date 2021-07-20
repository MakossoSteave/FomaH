<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Formation;
use Illuminate\Http\Request;

class FormationController extends Controller

{

    public function index()
    {
        $data = Formation::orderBy('id','desc')->paginate(3)->setPath('centre');
                   
        return view('centre..index',compact(['data']));
    }

    public function create()
    {
        $Categorie = Categorie::all();

        return view('centre.Ajoutforma',compact(['Categorie']));
    }

    public function store(Request $request)
    {
        $request->validate([
         'libelle' => 'required',
         'description' => 'required',
         'volume_horaire' => 'required',
         'reference' => 'required',
         'prix' => 'required',
         'userRef'=>'required',
         'categorie_id' =>'required'
        ]);
        do {
            $id = rand(10000000, 99999999);
        } while(Formation::find($id)!=null);

        Formation::create($request->all() + ['etat' => 0] + ['id' => $id]+ ['nombre_cours_total' => 0]+ ['nombre_chapitre_total' => 0]);
       // $this->etat($id);
        return redirect()->back()->with('success','Create Successfully');
    }

    public function show($id)
    {
       $data =  Formation::find($id);

       return view('centre.formation.show',compact(['data']));
    }

    public function edit($id)
    {
       $data = Formation::find($id);
       $Categorie = Categorie::all();

       return view('centre.formation.edit',compact(['data'], ['Categorie']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
         'libelle' => 'required',
         'description' => 'required',
         'volume_horaire' => 'required',
         'nombre_cours_total' => 'required',
         'nombre_chapitre_total' => 'required',
         'prix' => 'required',
         'userRef'=>'required',
         'categorie_id' =>'required'
        ]);

        Formation::where('id',$id)->update($request->all());   
        return redirect()->back()->with('success','Modifié avec succes');
        
    }
    public function etat($id)
    {
        $formation = Formation::find($id);
        $etat = $formation->etat;
        Formation::where('id', $id)->update(array('etat' => !$etat));
        return redirect()->back()->with('success','Modifié avec succes');
    }

    public function destroy($id)
    {
        Formation::where('id',$id)->delete();
        return redirect()->back()->with('success','Supprimé avec succes');
    }

}