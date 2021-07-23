<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Formation;
use Illuminate\Http\Request;

class FormationAdminController extends Controller

{

    public function index()
    {
        $formations = Formation::orderBy('id','desc')->paginate(3)->setPath('centre');
                   
        return view('admin.formation.index',compact(['formations']));
    }

    public function create()
    {
        $Categorie = Categorie::all();

        return view('admin.formation.create',compact(['Categorie']));
    }

    public function store(Request $request)
    {
        $request->validate([
         'libelle' => 'required',
         'description' => 'required',
         'volume_horaire' => 'required',
         'prix' => 'required',
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

       return view('admin.formation.show',compact(['data']));
    }

    public function edit($id)
    {
       $data = Formation::find($id);
       $Categorie = Categorie::all();

       return view('admin.formation.edit',compact(['data'], ['Categorie']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
         'libelle' => 'required',
         'description' => 'required',
         'volume_horaire' => 'required',
         'prix' => 'required',
         'categorie_id' =>'required',
         'etat' => 'required'
        ]);

        Formation::where('id',$id)->update($request->all());   
        // $this->Update_nombre_chapitre_total($id,-1);
        return redirect()->back()->with('success','Modifié avec succes');
        
    }

    public function Update_nombre_cours_total($id,$operation)
    {
        $formation = Formation::find($id);
        $nombre_cours_total = $formation->nombre_cours_total+$operation;
        if($nombre_cours_total<0) $nombre_cours_total=0;
        Formation::where('id', $id)->update(array('nombre_cours_total' => $nombre_cours_total));
    }

    public function Update_nombre_chapitre_total($id,$operation)
    {
        $formation = Formation::find($id);
        $nombre_chapitre_total = $formation->nombre_chapitre_total+$operation;
        if($nombre_chapitre_total<0) $nombre_chapitre_total=0;
        Formation::where('id', $id)->update(array('nombre_chapitre_total' => $nombre_chapitre_total));
    }

    public function etat($id)
    {
        $formation = Formation::find($id);
        $etat = !$formation->etat;
        Formation::where('id', $id)->update(array('etat' => $etat));
        return redirect()->back()->with('success','Modifié avec succes');
    }

    public function destroy($id)
    {
        Formation::where('id',$id)->delete();
        return redirect()->back()->with('success','Supprimé avec succes');
    }

}