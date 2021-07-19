<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Formations;
use Illuminate\Http\Request;

class FormationController extends Controller

{

    public function index()
    {
        $data = Formations::orderBy('id','desc')->paginate(3)->setPath('centre');
                   
        return view('centre..index',compact(['data']));
    }

    public function create()
    {
        $categories = Categories::all();

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

        Formations::create($request->all());
        return redirect()->back()->with('success','Create Successfully');
    }

    public function show($id)
    {
       $data =  Formations::find($id);

       return view('centre.formation.show',compact(['data']));
    }

    public function edit($id)
    {
       $data = Formations::find($id);
       $categories = Categories::all();

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

        Formations::where('id',$id)->update($request->all());
        return redirect()->back()->with('success','Modifié avec succes');
        
    }

    public function destroy($id)
    {
        Formations::where('id',$id)->delete();
        return redirect()->back()->with('success','Supprimé avec succes');
    }

}