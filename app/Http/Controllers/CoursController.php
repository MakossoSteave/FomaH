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
        $cours = Cours::select('cours.*', 'formations.libelle','formateurs.id as formateurID','formateurs.nom as formateurNom','formateurs.prenom as formateurPrenom')
        ->leftJoin('formations_contenir_cours', 'cours.id_cours', '=', 'formations_contenir_cours.id_cours')
        ->leftJoin('formations', 'formations.id',"=","formations_contenir_cours.id_formation")
        ->leftJoin('formateurs', 'formateurs.id',"=","cours.formateur")
        ->orderBy('created_at','asc')
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
      
        $utilisateurID = Auth::user()->id;

        $numero_cours = Cours::select('cours.numero_cours')
        ->leftJoin('formations_contenir_cours', 'cours.id_cours', '=', 'formations_contenir_cours.id_cours')
        ->leftJoin('formations', 'formations.id',"=","formations_contenir_cours.id_formation")
        ->where('formations.id','=',$request->get('formation_id'))
        ->max('numero_cours');

        Cours::create([
            'id_cours' => $id,
            'designation' => $request->get('designation'),
            'image' => $image,
            'prix' => $request->get('prix'),
            'formateur' =>  $utilisateurID,
            'etat' => 0,
            'nombre_chapitres' => 0,
            'numero_cours' => $numero_cours++
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
        FormationsContenirCours::where('id_cours',$id)->delete();
        Cours::where('id_cours',$id)->delete();

        return redirect('/cours')->with('success','Cours supprimé avec succes');
    }
}
