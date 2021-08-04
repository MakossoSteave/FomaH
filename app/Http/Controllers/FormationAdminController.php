<?php

namespace App\Http\Controllers;
//use App\Http\Controllers\CoursController;
use Illuminate\Http\Request;

use App\Models\FormationsContenirCours;
use App\Models\Categorie;
use App\Models\Formation;
use App\Models\Cours;
use Illuminate\Validation\Rule;
use App\Rules\FilenameImage;

class FormationAdminController extends Controller

{

    public function index()
    {
        $formations = Formation::orderBy('id','desc')->paginate(3)->setPath('cursus');
                   
        return view('admin.formation.index',compact(['formations']));
    }

    public function create()
    {
        $categories = Categorie::all();

        return view('admin.formation.create',compact(['categories']));
    }

    public function store(Request $request)
    {
        $request->validate([
         'libelle' => ['required','max:191','unique:formations'],
         'description' => ['required','max:1000'],
         'volume_horaire' =>  ['required','numeric','min:0'],
         'prix' =>  ['required','numeric','min:0'],
         'categorie_id' =>'required',
         'image' => ['mimes:jpeg,png,bmp,tiff,jfif,gif,GIF ','max:10000',
         new FilenameImage('/^[a-zA-Z0-9_.-^\s]{4,181}$/')]
        ]);

        do {
            $id = rand(10000000, 99999999);
        } while(Formation::find($id)!=null);

        if ($request->hasFile('image')) {
            $destinationPath = public_path('img/formation/');
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $image = time().$filename;
            $file->move($destinationPath, $image);
        } else {
            $image = null;
        }

        Formation::create([
            'id' => $id,
            'libelle' => $request->get('libelle'),
            'description' => $request->get('description'),
            'image' => $image,
            'volume_horaire' => $request->get('volume_horaire'),
            'prix' => $request->get('prix'),
            'etat' => 0,
            'nombre_cours_total' => 0,
            'nombre_chapitre_total' => 0,
            'categorie_id' => $request->get('categorie_id')
        ]);
       // $this->etat($id);
        return redirect('/cursus')->with('success','Formation créé avec succès');
    }

    public function show($id)
    {
       $data =  Formation::find($id);

       return view('admin.formation.show',compact(['data']));
    }

    public function edit($id)
    {
       $formation = Formation::find($id);
       $categories = Categorie::all();

       return view('admin.formation.edit',compact(['formation'], ['categories']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
         'libelle' =>['required','max:191', Rule::unique('formations')->where(function ($query) use($id) {
             
            return $query->where('id',"!=", $id);
        })] ,
         'description' => ['required','max:1000'],
         'volume_horaire' =>  ['required','numeric','min:0'],
         'prix' =>  ['required','numeric','min:0'],
         'categorie_id' =>'required',
         'etat' => [
            'required',
             Rule::in(['0', '1'])],
             'image' => ['mimes:jpeg,png,bmp,tiff,jfif,gif,GIF ','max:10000',
             new FilenameImage('/^[a-zA-Z0-9_.-^\s]{4,181}$/')]
        ]);

        if ($request->hasFile('image')) {
            $destinationPath = public_path('img/formation/');
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $image = time().$filename;
            $file->move($destinationPath, $image);
        } else {
            $image = $request->get('image-link');
        }
        $etat = $request->get('etat');
        $etatCanChange=true;
        if($etat==1){
        
            $coursDeLaFormation = FormationsContenirCours::select('id_cours')
            ->where('id_formation',$id)
            ->get();
            $cours = Cours::where('etat',"=",1)
           
            ->whereIn('id_cours',$coursDeLaFormation)
            ->count();
            
            if( $cours ==0){
                $etat=0;
                $etatCanChange=false;
            }
        }
        Formation::where('id',$id)->update([
            'libelle' => $request->get('libelle'),
            'description' => $request->get('description'),
            'image' => $image,
            'volume_horaire' => $request->get('volume_horaire'),
            'prix' => $request->get('prix'),
            'etat' => $etat,
            'categorie_id' => $request->get('categorie_id')
        ]);
        if(!$etatCanChange){
            return redirect('/cursus')->with('success','Formation modifié avec succès')
            ->with('error',"L'état ne peut pas être modifié car aucun cours n'est actif ! ");
        }else {
            return redirect('/cursus')->with('success','Formation modifié avec succès');
        }
      
        
    }

    public function createCours($id)
    {
        $coursDeLaFormation = Cours::select('cours.id_cours')
       
       ->leftJoin('formations_contenir_cours', 'formations_contenir_cours.id_cours', '=','cours.id_cours')
        ->where('formations_contenir_cours.id_formation',"=",$id)
       ->get();

        $cours = Cours::select('cours.*')
        ->whereNotIn('id_cours',$coursDeLaFormation)
        ->get();

       return view('admin.formation.cours.create',compact(['cours'], 'id'));
    }

    public function addCours(Request $request, $id)
    {
        $Cours = Cours::find($request->get('id_cours'));
        //$numero_cours = FormationsContenirCours::where("id_formation","=",$id)->max('numero_cours');
        if($Cours->etat==1){
        $numero_cours = FormationsContenirCours::where("id_formation","=",$id)->count();
            if ($numero_cours == null) {
                $numero_cours = 1;
            } else {
                $numero_cours = $numero_cours+1;
            }
        }
        else {
            $numero_cours = 0;
        }
        FormationsContenirCours::create([
            'id_cours' => $request->get('id_cours'),
            'id_formation' => $id,
            'numero_cours' => $numero_cours
        ]);
       
        if($Cours->etat==1){
            $this->Update_nombre_cours_total($id,1);
       
            $CoursNombreChapitre = $Cours->nombre_chapitres;
            $this->Update_nombre_chapitre_total($id,$CoursNombreChapitre);
        }
       

       return redirect('/cours/'.intval($id))->with('success','Le cours a été ajouté avec succès');
    }

    public function newCours($id)
    {
        $formations = Formation::orderBy('libelle','asc')->get();

       return view('admin.cours.create', compact(['formations'], 'id'));
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
        $etatCanChange=true;
        if($etat==1){
        
            $coursDeLaFormation = FormationsContenirCours::select('id_cours')
            ->where('id_formation',$id)
            ->get();
            $cours = Cours::where('etat',"=",1)
           
            ->whereIn('id_cours',$coursDeLaFormation)
            ->count();
            
            if( $cours ==0){
                $etat=0;
                $etatCanChange=false;
            }
        }
        if(!$etatCanChange){
            return redirect()->back()->with('error',"L'état ne peut pas être modifié car aucun cours n'est actif ! ");
        }else {
        Formation::where('id', $id)->update(array('etat' => $etat));
        return redirect()->back()->with('success','Modifié avec succès');
        }
       
    }

    public function destroy($id)
    {
        Formation::where('id',$id)->delete();
        return redirect()->back()->with('success','Supprimé avec succès');
    }
    public function removeCours($idCours,$idFormation){

        $formationContenirCours = FormationsContenirCours::
            where('id_cours',$idCours)
            ->where('id_formation',$idFormation)
            ->first();
            $Cours  = Cours::find($idCours);

            $Formation= new FormationAdminController;

            $cours = Cours::find($idCours);
            $formationContenirCours = FormationsContenirCours::
                where('id_cours',$idCours)->get();
                $nombreChapitresCours=Cours::where('id_cours',$idCours)->value('nombre_chapitres');
            foreach($formationContenirCours as $f)
            {
                
                if($cours->etat==1){
    
                // Mettre à jour le nombre de cours total dans chaque formations
                $Formation->Update_nombre_cours_total($f->id_formation,-1);
                
                // Mettre à jour le nombre de chapitre total dans chaque formations
    
                $Formation->Update_nombre_chapitre_total($f->id_formation,-$nombreChapitresCours);
                
                 }
                 // Supprimer le cours des formations
                 FormationsContenirCours::where('id_cours',$idCours)->delete();
                 // Mettre à jour le numero de cours dans chaque formations
                FormationsContenirCours::where('id_formation',$f->id_formation)
                ->where("numero_cours",">",$f->numero_cours)
                ->decrement('numero_cours',1);
            }
        
        

        $CoursController = new CoursController;
        $CoursController->checkEtat($idCours);
/*
        $coursDeLaFormation = FormationsContenirCours::select('id_cours')
            ->where('id_formation',$idFormation)
            ->get();
            
            $coursNumber = Cours::where('etat',"=",1)
            ->whereIn('id_cours',$coursDeLaFormation)
            ->where('id_cours',"!=",$idCours)
            ->count();
        
        if(  $coursNumber==0){

 Formation::where('id',$idFormation)->update([
                    
                    'etat' => 0
                   
                ]);}

*/
        FormationsContenirCours::where('id_cours',$idCours)
        ->where('id_formation',$idFormation)->delete();

      
        return redirect()->back()->with('success','Supprimé avec succès');
    } 
}