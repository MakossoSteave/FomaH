<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cours;

class CoursController extends Controller
{
    public function index()
    {
        $cours = Cours::select('cours.*', 'formations.libelle')
        ->join('formations_contenir_cours', 'cours.id_cours', '=', 'formations_contenir_cours.id_cours')
        ->join('formations', 'formations.id',"=","formations_contenir_cours.id_formation")
        ->orderBy('numero_cours','asc')
        ->paginate(5)->setPath('cours');
                   
        return view('cours.index',compact(['cours']));
    }

    public function create()
    {
        return view('cours.create');
    }

    public function store(Request $request)
    {
        $request->validate([
         'designation' => 'required',
         'prix' => 'required'
        ]);

        do {
            $id = rand(1000000, 99999999);
        } while(Cours::find($id) != null);

        if ($request->hasFile('image')) {
            $destinationPath = public_path('img/cours/');
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $image = time().$filename;
            $file->move($destinationPath, $image);
        } else {
            $image = null;
        }

        Cours::create([
            'id_cours' => $id,
            'designation' => $request->get('designation'),
            'image' => $image,
            'prix' => $request->get('prix'),
            'formateur' => 'Jhon Doe',
            'etat' => 0,
            'nombre_chapitres' => 0,
            'numero_cours' => 1
        ]);

        return redirect('/cours')->with('success','Cours créé avec succès');
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

       return view('cours.edit',compact(['cours']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'numero_cours' => 'required',
            'designation' => 'required',
            'prix' => 'required'
        ]);

    
        if ($request->hasFile('image')) {
            $destinationPath = public_path('img/cours/');
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $image = time().$filename;
            $file->move($destinationPath, $image);
        } else {
            $image = null;
        }

        Cours::where('cours_id', $id)->update([
            'designation' => $request->get('designation'),
            'image' => $image,
            'prix' => $request->get('prix'),
            'formateur' => 'Jhon Doe',
            'etat' => 0,
            'nombre_chapitres' => 0
        ]);

        return redirect('/cours')->with('success','Cours modifié avec succes');
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

        return redirect('/cours')->with('success','Cours supprimé avec succes');
    }
}
