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
        $categories = Categorie::all();

        return view('centre.Ajoutforma',compact(['categories']));
    }

    public function store(Request $request)
    {
        $request->validate([
         'libelle' => 'required',
         'description' => 'required',
         'volume_horaire' => 'required',
         'nombre_cours_total' => 'required',
         'nombre_chapitre_total' => 'required',
         'etat' => 'required',
         'reference' => 'required',
         'prix' => 'required',
         'userRef'=>'required',
         'categorie_id' =>'required'
        ]);

        Formation::create($request->all());
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
       $categories = Categorie::all();

       return view('centre.formation.edit',compact(['data'], ['categories']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
         'libelle' => 'required',
         'description' => 'required',
         'volume_horaire' => 'required',
         'nombre_cours_total' => 'required',
         'nombre_chapitre_total' => 'required',
         'etat' => 'required',
         'prix' => 'required',
         'userRef'=>'required',
         'categorie_id' =>'required'
        ]);

        Formation::where('id',$id)->update($request->all());
        return redirect()->back()->with('success','Modifié avec succes');
        
    }

    public function destroy($id)
    {
        Formation::where('id',$id)->delete();
        return redirect()->back()->with('success','Supprimé avec succes');
    }

}