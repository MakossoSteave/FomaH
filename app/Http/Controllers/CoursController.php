<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\FormationsContenirCours;
use App\Models\Formation;
use App\Models\Cours;

class CoursController extends Controller
{
    public function index()
    {
        $cours = Cours::select('cours.*', 'formations.libelle')
        ->join('formations_contenir_cours', 'cours.id_cours', '=', 'formations_contenir_cours.id_cours')
        ->join('formations', 'formations.id',"=","formations_contenir_cours.id_formation")
        ->distinct()
        ->orderBy('numero_cours','asc')
        ->paginate(5)->setPath('cours');
                   
        return view('cours.index',compact(['cours']));
    }

    public function create()
    {
        $formations = Formation::orderBy('libelle','asc')->get();

        return view('cours.create', compact(['formations']));
    }

    public function store(Request $request)
    {
        $request->validate([
         'numero_cours' => 'required',
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
            'numero_cours' => $request->get('numero_cours'),
            'designation' => $request->get('designation'),
            'image' => $image,
            'prix' => $request->get('prix'),
            'formateur' => Auth::user()->name,
            'etat' => 0,
            'nombre_chapitres' => 0
        ]);

        FormationsContenirCours::create([
            'id_cours' => $id,
            'id_formation' => $request->get('formation_id')
        ]);

        return redirect('/cours')->with('success','Cours créé avec succès');
    }

    public function show($id)
    {
       $cours = Cours::find($id);

       return view('cours.show',compact(['cours']));
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
            $image = $request->get('image-link');
        }

        Cours::where('id_cours', $id)->update([
            'numero_cours' => $request->get('numero_cours'),
            'designation' => $request->get('designation'),
            'image' => $image,
            'prix' => $request->get('prix'),
            'formateur' => $request->get('formateur'),
            'etat' => 0,
            'nombre_chapitres' => 0
        ]);

        return redirect('/cours')->with('success','Cours modifié avec succes');
    }

    public function destroy($id)
    {
        FormationsContenirCours::where('id_cours',$id)->delete();
        Cours::where('id_cours',$id)->delete();

        return redirect('/cours')->with('success','Cours supprimé avec succes');
    }
}
