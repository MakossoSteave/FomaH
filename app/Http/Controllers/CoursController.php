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
        $cours = Cours::select('cours.*', 'formateurs.id as formateurID','formateurs.nom as formateurNom','formateurs.prenom as formateurPrenom')
        ->leftJoin('formateurs', 'formateurs.id',"=","cours.formateur")
        ->orderBy('created_at','asc')
        ->paginate(5)->setPath('cours');
                   
        return view('admin.cours.index',compact(['cours']));
    }

    public function create()
    {
        $formations = Formation::orderBy('libelle','asc')->get();

        return view('admin.cours.create', compact(['formations']));
    }

    public function store(Request $request)
    {
        $request->validate([
         'designation' => 'required',
         'prix' => 'required'
        ]);

        do {
            $id = rand(10000000, 99999999);
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
        $formateur= new FormateurController;
        $formateurID= $formateur->findFormateurID($utilisateurID);      

        Cours::create([
            'id_cours' => $id,
            'designation' => $request->get('designation'),
            'image' => $image,
            'prix' => $request->get('prix'),
            'formateur' =>  $formateurID,
            'etat' => 0,
            'nombre_chapitres' => 0
        ]);

        if($request->get('formation_id')!="") {
            $numero_cours = FormationsContenirCours::where("id_formation","=",$request->get('formation_id'))->max('numero_cours');

            if ($numero_cours == null) {
                $numero_cours = 1;
            } else {
                $numero_cours = $numero_cours+1;
            }
                FormationsContenirCours::create([
                'id_cours' => $id,
                'id_formation' => $request->get('formation_id'),
                'numero_cours' => $numero_cours
            ]);
           $Formation= new FormationController;
           $Formation->Update_nombre_cours_total($request->get('formation_id'),1);
        }
       
        return redirect('/cours')->with('success','Cours créé avec succès');
    }

    public function show($id)
    {
       $cours = Cours::find($id);

       return view('admin.cours.show',compact(['cours']));
    }

    public function findCours($id)
    {
       $cours = Cours::find($id);

       return $cours;
    }

    public function edit($id)
    {
       $cours = Cours::find($id);

       return view('admin.cours.edit',compact(['cours']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'designation' => 'required',
            'prix' => 'required',
            'etat' => 'required'
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
            'designation' => $request->get('designation'),
            'image' => $image,
            'prix' => $request->get('prix'),
            'formateur' => $request->get('formateur'),
            'etat' => $request->get('etat'),
            'nombre_chapitres' => 0
        ]);

        return redirect('/cours')->with('success','Cours modifié avec succes');
    }

    // public function Update_numero_cours($id_cours,$operation)
    // {
    //     $Cours = Cours::find($id_cours);
    //     $numero_cours = $Cours->numero_cours+$operation;
    //     if($numero_cours<0) $numero_cours=0;
    //     Cours::where('id_cours', $id_cours)->update(array('numero_cours' => $numero_cours));
    // }

    public function Update_nombre_chapitres($id_cours,$operation)
    {
        $Cours = Cours::find($id_cours);
        $nombre_chapitres = $Cours->nombre_chapitres+$operation;
        if($nombre_chapitres<0) $nombre_chapitres=0;
        Cours::where('id_cours', $id_cours)->update(array('nombre_chapitres' => $nombre_chapitres));
    }

    public function etat($id)
    {
        $cours = Cours::find($id);
        $etat = !$cours->etat;
        Cours::where('id_cours', $id)->update(array('etat' => $etat));
        return redirect()->back()->with('success','Modifié avec succes');
    }
    public function destroy($id)
    {
        // nombre de chapitres du cours
        $nombreChapitresCours=Cours::where('id_cours',$id)->value('nombre_chapitres');
        // toutes les id formations qui contienent le cours
     
        $formationContenirCours = FormationsContenirCours::
            where('id_cours',$id)->get();
        // Supprimer le cours des formations
        FormationsContenirCours::where('id_cours',$id)->delete();
        
        $Formation= new FormationController;

        
        foreach($formationContenirCours as $f)
        {
            // Mettre à jour le nombre de cours total dans chaque formations

            $Formation->Update_nombre_cours_total($f->id_formation,-1);

            // Mettre à jour le nombre de chapitre total dans chaque formations

            $Formation->Update_nombre_chapitre_total($f->id_formation,-$nombreChapitresCours);
            // Mettre à jour le numero de cours dans chaque formations

            FormationsContenirCours::where('id_formation',$f->id_formation)
            ->where("numero_cours",">",$f->numero_cours)
            ->decrement('numero_cours',1);
        }
        // Supprimer le cours
        Cours::where('id_cours',$id)->delete();

        return redirect('/cours')->with('success','Cours supprimé avec succes');
    }
}
