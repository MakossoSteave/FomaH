<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapitre;
class ChapitreController extends Controller
{
   /* public function create()
    {
        $Categorie = Categorie::all();

        return view('centre.Ajoutforma',compact(['Categorie']));
    }*/

    public function store(Request $request)
    {
        $request->validate([
         'designation' => 'required',
         'video' => 'required',
         'id_cours' => 'required'
        ]);
        do {
            $id_chapitre = rand(10000000, 99999999);
        } while(Chapitre::where("id_chapitre",$id_chapitre)!=null);
        $numero_chapitre=0;//from cours
        Chapitre::create($request->all() + ['numero_chapitre' => $numero_chapitre] + ['id_chapitre' => $id_chapitre]);
       // $this->etat($id_chapitre);
        return redirect()->back()->with('success','Create Successfully');
    }

    public function show($id_chapitre)
    {
       $data =  Chapitre::find($id_chapitre);

       return view('centre.Chapitre.show',compact(['data']));
    }

    public function edit($id_chapitre)
    {
       $data = Chapitre::find($id_chapitre);
      

       return view('centre.Chapitre.edit',compact(['data']));
    }

    public function update(Request $request, $id_chapitre)
    {
        $request->validate([
            'designation' => 'required',
            'video' => 'required',
            'id_cours' => 'required'
        ]);

        Chapitre::where('id_chapitre',$id_chapitre)->update($request->all());   
        return redirect()->back()->with('success','Modifié avec succes');
        
    }
    public function Update_numero_chapitre($id_chapitre,$operation)
    {
        $Chapitre = Chapitre::find($id_chapitre);
        $numero_chapitre = $Chapitre->numero_chapitre;
        Chapitre::where('id_chapitre', $id_chapitre)->update(array('numero_chapitre' => $numero_chapitre+$operation));
    }
    public function etat($id_chapitre)
    {
        $Chapitre = Chapitre::find($id_chapitre);
        $etat = $Chapitre->etat;
        Chapitre::where('id_chapitre', $id_chapitre)->update(array('etat' => !$etat));
        return redirect()->back()->with('success','Modifié avec succes');
    }
    public function destroy($id_chapitre)
    {
        Chapitre::where('id_chapitre',$id_chapitre)->delete();
        return redirect()->back()->with('success','Supprimé avec succes');
    }

}