<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formation;
use App\Models\Cours;

class CoursController extends Controller
{
    public function index()
    {
        $cours = Cours::join('formations', 'formations.id', '=', 'cours.formation_id')
        ->select('cours.*','formations.image as formationImage')
        ->orderBy('numero_cours','desc')
        ->paginate(5)->setPath('cours');
      
                   
        return view('cours.index',compact(['cours']));
    }

    public function create()
    {
        $formations = Formation::all();

        return view('cours.addCours',compact(['formations']));
    }

    public function store(Request $request)
    {
        $request->validate([
         'numero_cours' => 'required',
         'designation' => 'required',
         'image' => 'required',
         'nombre_chapitres' => 'required',
         'prix' => 'required',
         'formation_id' =>'required'
        ]);

        do {
            $id = rand(1000000, 99999999);
        } while(Cours::find($id) != null);

        Cours::create($request->all() + ['etat' => 0] + ['cours_id' => $id]);

        return redirect()->back()->with('success','Create Successfully');
    }

    public function findOne($id)
    {
       $cours = Cours::find($id);

       return view('cours.getOne',compact(['cours']));
    }
    public function findCours($id)
    {
       $cours = Cours::find($id);

       return $cours;
    }
    public function edit($id)
    {
       $cours = Cours::find($id);
       $formations = Formation::all();

       return view('cours.edit',compact(['cours'], ['formations']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'numero_cours' => 'required',
            'designation' => 'required',
            'image' => 'required',
            'nombre_chapitres' => 'required',
            'prix' => 'required',
            'formation_id' =>'required'
        ]);

        Cours::where('cours_id',$id)->update($request->all());

        return redirect()->back()->with('success','Modifié avec succes');
    }
    public function Update_numero_cours($id_cours,$operation)
    {
        $Cours = Cours::find($id_cours);
        $numero_cours = $Cours->numero_cours+$operation;
        if($numero_cours<0) $numero_cours=0;
        Cours::where('id_cours', $id_cours)->update(array('numero_cours' => $numero_cours));
    }
    public function Update_nombre_chapitres($id_cours,$operation)
    {
        $Cours = Cours::find($id_cours);
        $nombre_chapitres = $Cours->nombre_chapitres+$operation;
        if($nombre_chapitres<0) $nombre_chapitres=0;
        Cours::where('id_cours', $id_cours)->update(array('nombre_chapitres' => $nombre_chapitres));
    }
    public function destroy($id)
    {
        Cours::where('cours_id',$id)->delete();

        return redirect()->back()->with('success','Supprimé avec succes');
    }
}
