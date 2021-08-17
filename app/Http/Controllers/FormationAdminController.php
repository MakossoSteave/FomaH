<?php

namespace App\Http\Controllers;
//use App\Http\Controllers\CoursController;
use Illuminate\Http\Request;

use App\Models\FormationsContenirCours;
use App\Models\Categorie;
use App\Models\Formation;
use App\Models\Formateur;
use App\Models\Cours;
use App\Models\Session;
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
         'effectif' =>  ['required','numeric','min:1'],
         'categorie_id' =>'required',
         'image' => ['mimes:jpeg,png,bmp,tif,gif,ico,jpg,jpg,GIF ','max:10000',
         new FilenameImage('/[\w\W]{4,181}$/')]
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
            'effectif' =>  $request->get('effectif'),
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
         'effectif' =>  ['required','numeric','min:1'],
         'categorie_id' =>'required',
         'etat' => [
            'required',
             Rule::in(['0', '1'])],
             'image' => ['mimes:jpeg,png,bmp,tif,gif,ico,jpg,jpg,GIF ','max:10000',
             new FilenameImage('/[\w\W]{4,181}$/')]
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
        $etatCanChangeCours=true;
        $etatCanChangeSession=true;
        if($etat==1){
        
            $coursDeLaFormation = FormationsContenirCours::select('id_cours')
            ->where('id_formation',$id)
            ->get();
            $cours = Cours::where('etat',"=",1)
           
            ->whereIn('id_cours',$coursDeLaFormation)
            ->count();
            
            if( $cours ==0){
                $etat=0;
                $etatCanChangeCours=false;
            }
        }else {
            $session =  Session::where('formations_id',$id)
            ->where('etat',1)
            
            ->first();
            if($session!=null){
                $etat=1;
                $etatCanChangeSession=false;
            }
        }
        Formation::where('id',$id)->update([
            'libelle' => $request->get('libelle'),
            'description' => $request->get('description'),
            'image' => $image,
            'volume_horaire' => $request->get('volume_horaire'),
            'prix' => $request->get('prix'),
            'effectif' => $request->get('effectif'),
            'etat' => $etat,
            'categorie_id' => $request->get('categorie_id')
        ]);
        if(!$etatCanChangeCours){
            return redirect('/cursus')->with('success','Formation modifié avec succès')
            ->with('error',"L'état ne peut pas être modifié car aucun cours n'est actif ! ");
        }  else if(!$etatCanChangeSession){
            return redirect('/cursus')->with('success','Formation modifié avec succès')->with('error',"L'état ne peut pas être modifié car une session est active ! ");
        }
        else {
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
        $numero_cours = FormationsContenirCours::where("id_formation","=",$id)->max('numero_cours');
    
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

        $formateurs = Formateur::orderBy('nom','asc')->get();

        return view('admin.cours.create', compact(['formations'], ['formateurs'], 'id'));
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
        $etatCanChangeCours=true;
        $etatCanChangeSession=true;
        if($etat==1){
        
            $coursDeLaFormation = FormationsContenirCours::select('id_cours')
            ->where('id_formation',$id)
            ->get();
            $cours = Cours::where('etat',"=",1)
           
            ->whereIn('id_cours',$coursDeLaFormation)
            ->count();
            
            if( $cours ==0){
                $etat=0;
                $etatCanChangeCours=false;
            }
        }else {
            $session =  Session::where('formations_id',$id)
            ->where('etat',1)
            
            ->first();
            if($session!=null){
                $etat=1;
                $etatCanChangeSession=false;
            }
        }
        if(!$etatCanChangeCours){
            return redirect()->back()->with('error',"L'état ne peut pas être modifié car aucun cours n'est actif ! ");
        }
        else if(!$etatCanChangeSession){
            return redirect()->back()->with('error',"L'état ne peut pas être modifié car une session est active ! ");
        }
        else {
        Formation::where('id', $id)->update(array('etat' => $etat));
        return redirect()->back()->with('success','Etat modifié avec succès');
        }
       
    }

    public function destroy($id)
    {
        
  $session =  Session::where('formations_id',$id)
  ->where('etat',1)
  
  ->first();
  if($session!=null){
    return redirect()->back()->with('error','Ne peut pas être supprimé car une session est active !');
  } else{
    Formation::where('id',$id)->delete();
    return redirect()->back()->with('success','Supprimé avec succès');
  }
        
    }
    public function removeCours($idCours,$idFormation){
        $cours = Cours::find($idCours);
        if($cours->etat==1){
            $Formation=FormationsContenirCours::where('id_cours',$idCours)
            ->get();
            foreach($Formation as $f){
              //  $cursus=Formation::where('id',$f->id_formation)->where('nombre_chapitre_total',1)->get();
                $session =  Session::where('formations_id',$f->id_formation)
                ->where('etat',1)
                ->where('statut_id',3)
                ->first();
                if($session!=null /*&& $cursus!=null*/){
                    return redirect()->back()->with('error','Ne peut pas être supprimé car une session est active');
                }
            }
        }
        
  $formationContenirCours = FormationsContenirCours::
            where('id_cours',$idCours)
            ->where('id_formation',$idFormation)
            ->first();
            $Cours  = Cours::find($idCours);

            $Formation= new FormationAdminController;

            
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
                FormationsContenirCours::where('id_formation',$f->id_formation)
                ->where("numero_cours",">",$f->numero_cours)
                ->decrement('numero_cours',1);
                 }
                 // Supprimer le cours des formations
                 FormationsContenirCours::where('id_cours',$idCours)->delete();
                 // Mettre à jour le numero de cours dans chaque formations
               
            }
        
        

        $CoursController = new CoursController;
        $CoursController->checkEtat($idCours,false);
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