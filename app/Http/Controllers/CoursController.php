<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formation;
use App\Models\Cours;

class CoursController extends Controller
{
    public function index()
    {
        $cours = Cours::orderBy('numero_cours','desc')->paginate(5)->setPath('cours');

        $formations = Formation::find(56895263);
                   
        return view('cours.index',compact(['cours'], ['formations']));
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

    public function destroy($id)
    {
        Cours::where('cours_id',$id)->delete();

        return redirect()->back()->with('success','Supprimé avec succes');
    }
}
