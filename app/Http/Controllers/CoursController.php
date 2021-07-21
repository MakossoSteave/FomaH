<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formation;
use App\Models\Cours;

class CoursController extends Controller
{
    public function index()
    {
        $cours = Cours::select('cours.*', 'formations.libelle')
        ->join('formations', 'formations.id', '=', 'cours.formation_id')
        ->orderBy('numero_cours','asc')
        ->paginate(5)->setPath('cours');
                   
        return view('cours.index',compact(['cours']));
    }

    public function create()
    {
        $formations = Formation::all();

        return view('cours.create',compact(['formations']));
    }

    public function store(Request $request)
    {
        $request->validate([
         'numero_cours' => 'required',
         'designation' => 'required',
         'image' => 'required',
         'prix' => 'required',
         'formation_id' =>'required'
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
        } 

        Cours::create([
            'id_cours' => $id,
            'numero_cours' => $request->get('numero_cours'),
            'designation' => $request->get('designation'),
            'image' => $image,
            'prix' => $request->get('prix'),
            'formation_id' => $request->get('formation_id'),
            'etat' => 0,
            'nombre_chapitres' => 0
        ]);

        return redirect('/cours')->with('success','Cours créé avec succès');
    }

    public function findOne($id)
    {
       $cours = Cours::find($id);

       return view('cours.getOne',compact(['cours']));
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
            'prix' => 'required',
            'formation_id' =>'required'
        ]);

        Cours::where('cours_id',$id)->update($request->all());

        return redirect()->back()->with('success','Cours modifié avec succes');
    }

    public function destroy($id)
    {
        Cours::where('cours_id',$id)->delete();

        return redirect()->back()->with('success','Cours supprimé avec succes');
    }
}
