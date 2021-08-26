<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\FormationsContenirCours;
use App\Models\Formation;
use App\Models\Cours;
use App\Models\Chapitre;
use App\Models\Contenir_sessions_projet;
use App\Models\Formateur;
use App\Models\Lier_sessions_stagiaire;
use App\Models\Projet;
use App\Models\Session;
use App\Models\Suivre_formation;
use Illuminate\Validation\Rule;
use App\Rules\FilenameImage;

class CoursController extends Controller
{
    public function index()
    {
        $cours = Cours::select('cours.*', 'formateurs.id as formateurID','formateurs.nom as formateurNom','formateurs.prenom as formateurPrenom')
        ->leftJoin('formateurs', 'formateurs.id',"=","cours.formateur")
        ->orderBy('created_at','desc')
        ->paginate(5);

        //$test = FormationsContenirCours::with('formations')->with('cours')->get();
                   
    return view('admin.cours.index',compact(['cours']/*,['test']*/));
    }

    public function create()
    {
        $id = null;

        $formations = Formation::orderBy('libelle','asc')->get();

        $formateurs = Formateur::orderBy('nom','asc')->get();

        return view('admin.cours.create', compact(['formations','formateurs'], 'id'));
    }

    public function filter($id)
    {
        $cours = Cours::select('cours.*', 'formations.libelle', 'formateurs.id as formateurID','formateurs.nom as formateurNom','formateurs.prenom as formateurPrenom')
        ->join('formations_contenir_cours', 'cours.id_cours', '=', 'formations_contenir_cours.id_cours')
        ->join('formations', 'formations.id',"=","formations_contenir_cours.id_formation")
        ->leftJoin('formateurs', 'formateurs.id',"=","cours.formateur")
        ->where('formations.id','=',$id)
        ->orderBy('numero_cours','asc')
        ->paginate(5)->setPath("$id");

        return view('admin.cours.filter', compact(['cours']),["FormationID" => $id]);
    }

    public function store(Request $request)
    {
        $request->validate([
         'designation' => ['required','max:191', 'unique:cours'],
         'prix' => ['required','numeric','min:0'],
         'formateur_id' => ['nullable','numeric'],
          'image' => ['mimes:jpeg,png,bmp,tif,gif,ico,jpg,GIF','max:10000',
                 new FilenameImage('/[\w\W]{4,181}$/')]
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
      
        if (!empty($request->get('formateur_id'))) {
            $formateurID = $request->get('formateur_id');  
        }else{
            $formateurID = null;
        }
              

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
           // $numero_cours = FormationsContenirCours::where("id_formation","=",$request->get('formation_id'))->max('numero_cours');
          /* $numero_cours = FormationsContenirCours::where("id_formation","=",$request->get('formation_id'))->count();

            if ($numero_cours == null) {
                $numero_cours = 1;
            } else {
                $numero_cours = $numero_cours+1;
            }*/
                FormationsContenirCours::create([
                'id_cours' => $id,
                'id_formation' => $request->get('formation_id'),
                'numero_cours' => 0
            ]);
           $Formation= new FormationAdminController;
         //  $Formation->Update_nombre_cours_total($request->get('formation_id'),1);
        }
       
      
        if($request->get('formation_id')!="") {
        return redirect('/cours/'.intval($request->get('formation_id')))->with('success','Le cours a été ajouté avec succès');
        } else {
            return redirect('/cours')->with('success','Cours créé avec succès');
        }
    }

    public function show($id)
    {
       $cours = Cours::find($id);

       return view('admin.cours.show',compact(['cours']));
    }

  /*  public function findCours($id)
    {
       $cours = Cours::where('id_cours',$id)->get();

       return $cours;
    }
*/
    public function edit($idCours)
    {
    $cours = Cours::select('cours.*','formateurs.nom as NomFormateur','formateurs.prenom as PrenomFormateur')
    ->leftJoin('formateurs','cours.formateur','=','formateurs.id')
    ->where("id_cours",$idCours)
    ->first();
    $formateurs = Formateur::orderBy('nom','asc')->get();
    return view('admin.cours.edit',compact(['cours','formateurs']));
    }

    public function editFilter($idCours, $idFormation)
    {
        $cours = Cours::select('cours.*','formateurs.nom as NomFormateur','formateurs.prenom as PrenomFormateur')
        ->leftJoin('formateurs','cours.formateur','=','formateurs.id')
        ->where("id_cours",$idCours)
        ->first();
       $formateurs = Formateur::orderBy('nom','asc')->get();
       return view('admin.cours.edit',compact(['cours','formateurs'], ['idFormation']));
    }

    public function update(Request $request, $id)
    {
        $coursToUpdate=Cours::find($id);
        $request->validate([
            'designation' => ['required','max:191', Rule::unique('cours')->where(function ($query) use($id) {
             
                return $query->where('id_cours',"!=", $id);
            })] ,
            'formateur' => ['nullable','numeric'],
            'prix' => ['required','numeric','min:0'],
            'etat' => [
                'required',
                 Rule::in(['0', '1'])],
                 'image' => ['mimes:jpeg,png,bmp,tif,gif,ico,jpg,GIF ','max:10000',
                 new FilenameImage('/[\w\W]{4,181}$/')]
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
        $etat = $request->get('etat');
        $etatCanChange=true;
        $etatCanChangeProjet=true;
        $etatCanChangeSession=true;
        if($etat==1 && $etat!=$coursToUpdate->etat){
            $chapitre =  Chapitre::where('id_cours',$id)
            ->where('etat',1)
            ->count();
            $projet = Projet::where('id_cours',$id)
            ->where('etat',1)
            ->count();

            if($chapitre ==0){
                $etat=0;
                $etatCanChange=false;
            }
            else if($projet ==0){
                $etat=0;
                $etatCanChangeProjet=false;
            }
            else if($etat==1 && $etat!=$coursToUpdate->etat) {
                $formationContenirCours = FormationsContenirCours::
                    where('id_cours',$id)->get();
                foreach($formationContenirCours as $f)
                    { $Numero = FormationsContenirCours::where('id_formation',$f->id_formation)->max('numero_cours');
                        FormationsContenirCours::where('id_cours',$id)->update([
                            
                            'numero_cours' => $Numero+1
                        
                        ]);
                        $nombreChapitresCours=Cours::where('id_cours',$id)->value('nombre_chapitres');
                        $Formation= new FormationAdminController;
                        // Mettre à jour le nombre de cours total dans chaque formations
                        $Formation->Update_nombre_cours_total($f->id_formation,1);
                                    
                        // Mettre à jour le nombre de chapitre total dans chaque formations
        
                        $Formation->Update_nombre_chapitre_total($f->id_formation,$nombreChapitresCours);
                    
                        $session =  Session::where('formations_id',$f->id_formation)
                        ->where('etat',1)
                        ->where('statut_id',3)
                        ->get();
                        if($session!=null){
                            $projet = Projet::where('etat',1)
                            ->where('id_cours',$id)
                            ->first();
                            foreach($session as $s){
                            $exists = Contenir_sessions_projet::where('id_session',$s->id)
                            ->where('id_projet',$projet->id)->exists();
                
                            if(!$exists){
                                Contenir_sessions_projet::create([
                                    'id_projet' => $projet->id ,
                                    'id_session' => $s->id ,
                                    'statut_id' => 1,
                                    'date_debut' =>$session->date_debut,
                                    'date_fin' =>$session->date_fin
                                ]); 
                            }}
                        }
                    }

            }


        
            
        }else {
            if(!$this->checkCours($id)){
                $etatCanChangeSession=false;
                $etat=1;
            }else {
            //$this->Update_cours($id);
            $this->checkEtat($id,false);
            }
           
        }
      /*if($etat==1){
          $nbChap= $nombreChapitresCours+1;
      }
      else {
        $nbChap =$nombreChapitresCours; 
      }*/
     if(!empty($request->get('formateur'))){
        $formateur = $request->get('formateur');
     } else {
        $formateur = null;
     }
        Cours::where('id_cours', $id)->update([
            'designation' => $request->get('designation'),
            'image' => $image,
            'prix' => $request->get('prix'),
            'formateur' => $formateur,
            'etat' => $etat/*,
            'nombre_chapitres' =>  $nbChap*/
        ]);

        if(!$etatCanChange){
            return redirect('/cours/'.$request->get('formation_id'))->with('success','Cours modifié avec succès')
            ->with('error',"L'état ne peut pas être modifié car aucun chapitre n'est actif ! ");
        } else if(!$etatCanChangeSession){
            return redirect('/cours/'.$request->get('formation_id'))->with('success','Cours modifié avec succès')
            ->with('error',"L'état ne peut pas être modifié car une session est en cours ! ");
        } else if(!$etatCanChangeProjet){
            return redirect('/cours/'.$request->get('formation_id'))->with('success','Cours modifié avec succès')->with('error',"L'état ne peut pas être modifié car aucun projet n'est actif ! "); 
        }else {
            return redirect('/cours/'.$request->get('formation_id'))->with('success','Cours modifié avec succès');
        }
       
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

    public function Update_cours($id_cours)
    {
        $this->checkCoursSuivreFormation($id_cours);
         // nombre de chapitres du cours
        $nombreChapitresCours=Cours::where('id_cours',$id_cours)->value('nombre_chapitres');

        $Formation= new FormationAdminController;

        //$cours = Cours::find($id_cours);
        $formationContenirCours = FormationsContenirCours::
            where('id_cours',$id_cours)->get();
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
            FormationsContenirCours::where('id_cours',$id_cours)->update([
                            
                'numero_cours' => 0
            
            ]);
        }
    }
    
    public function etat($id)
    {
        $cours = Cours::find($id);
        $etat = !$cours->etat;
        $etatCanChangeChapitre=true;
        $etatCanChangeProjet=true;
        $etatCanChangeSession=true;
        if($etat==1){
            $chapitre =  Chapitre::where('id_cours',$id)
            ->where('etat',1)
            ->count();
            $projet = Projet::where('id_cours',$id)
            ->where('etat',1)
            ->count();
            if($chapitre ==0){
                $etat=0;
                $etatCanChangeChapitre=false;
            }
            else if($projet ==0){
                $etat=0;
                $etatCanChangeProjet=false;
            }
            else {
                $formationContenirCours = FormationsContenirCours::
                    where('id_cours',$id)->get();
                foreach($formationContenirCours as $f)
                    { $Numero = FormationsContenirCours::where('id_formation',$f->id_formation)->max('numero_cours');
                        FormationsContenirCours::where('id_cours',$id)->update([
                            
                            'numero_cours' => $Numero+1
                        
                        ]);

                        $nombreChapitresCours=Cours::where('id_cours',$id)->value('nombre_chapitres');
                        $Formation= new FormationAdminController;
                        // Mettre à jour le nombre de cours total dans chaque formations
                        $Formation->Update_nombre_cours_total($f->id_formation,1);
                                    
                        // Mettre à jour le nombre de chapitre total dans chaque formations
        
                        $session =  Session::where('formations_id',$f->id_formation)
                        ->where('etat',1)
                        ->where('statut_id',3)
                        ->get();
                        if($session!=null){
                            $projet = Projet::where('etat',1)
                            ->where('id_cours',$id)
                            ->first();
                            foreach($session as $s){
                            $exists = Contenir_sessions_projet::where('id_session',$s->id)
                            ->where('id_projet',$projet->id)->exists();
                
                            if(!$exists){
                                Contenir_sessions_projet::create([
                                    'id_projet' => $projet->id ,
                                    'id_session' => $s->id ,
                                    'statut_id' => 1,
                                    'date_debut' =>$session->date_debut,
                                    'date_fin' =>$session->date_fin
                                ]); 
                            }
                        }  }  $Formation->Update_nombre_chapitre_total($f->id_formation,$nombreChapitresCours);
                    
                    
                    
                    }

               
            }


        }   
        // etat == 0
        else {
            if(!$this->checkCours($id)){
                $etatCanChangeSession=false;
                $etat=1;
            }else {
            //$this->Update_cours($id);
            $this->checkEtat($id,false);
            
        }
            
        }
        //

        //return
        if(!$etatCanChangeChapitre){
            return redirect()->back()->with('error',"L'état ne peut pas être modifié car aucun chapitre n'est actif ! "); 
        }
        else if(!$etatCanChangeProjet){
            return redirect()->back()->with('error',"L'état ne peut pas être modifié car aucun projet n'est actif ! "); 
        }
        else if(!$etatCanChangeSession){
            return redirect()->back()->with('error',"L'état ne peut pas être modifié car une session est acitve ! "); 
        }
        else {
        Cours::where('id_cours', $id)->update(array('etat' => $etat));
        return redirect()->back()->with('success','Etat modifié avec succès');
    }
    }
    public function destroy($id)
    {
        $cours = Cours::find($id);
        if($cours->etat==1)
        {
            if(!$this->checkCours($id)){
            return redirect()->back()->with('error',"Ne peut pas être supprimé car une session est en cours");/* et aucun autre chapitre n'est actif");*/
            }
        }
       
        // toutes les id formations qui contienent le cours
        $this->checkEtat($id,true);
        $this->checkCoursSuivreFormation($id);
        
        /*************************** */

        // nombre de chapitres du cours
        $nombreChapitresCours=Cours::where('id_cours',$id)->value('nombre_chapitres');
        $Formation= new FormationAdminController;

        
        $formationContenirCours = FormationsContenirCours::
            where('id_cours',$id)->get();
        foreach($formationContenirCours as $f)
        {
            
            if($cours->etat==1){

            // Mettre à jour le nombre de cours total dans chaque formations
            $Formation->Update_nombre_cours_total($f->id_formation,-1);
            
            // Mettre à jour le nombre de chapitre total dans chaque formations

            $Formation->Update_nombre_chapitre_total($f->id_formation,-$nombreChapitresCours);
            
             }
             // Supprimer le cours des formations
             FormationsContenirCours::where('id_cours',$id)->delete();
             // Mettre à jour le numero de cours dans chaque formations
             if($cours->etat==1){ FormationsContenirCours::where('id_formation',$f->id_formation)
                ->where("numero_cours",">",$f->numero_cours)
                ->decrement('numero_cours',1);}
           
        }

         /*************************** */

        // Supprimer le cours
        Cours::where('id_cours',$id)->delete();
       
        return redirect()->back()->with('success','Cours supprimé avec succès');
    
    }
    public function checkEtat($id,$destroy){
        $cursus =  FormationsContenirCours::select('id_formation')
        ->where('id_cours',$id)->get();
     
       foreach($cursus as $c) {

            $coursDeLaFormation = FormationsContenirCours::select('id_cours')
            ->where('id_formation',$c->id_formation)
            ->get();
            
            $cours = Cours::where('etat',"=",1)
            ->whereIn('id_cours',$coursDeLaFormation)
            ->where('id_cours',"!=",$id)
            ->count();
        
            // $test = Cours::with('cours.formations')->get();
           /* $session =  Session::where('formations_id',$c->id_formation)
            ->where('etat',1)
            ->where('statut_id',3)
            ->first();*/

        if( $cours==0 /*&& $session==null*/){

         Formation::where('id',$c->id_formation)->update([
                    
                    'etat' => 0
                   
                ]);}
               Session::where('formations_id',$c->id_formation)->update([
                   'etat' => 0
               ]);
        }
        if(!$destroy){ $this->Update_cours($id); }
       
    }
    public function checkCours($id_cours){
       
        $Formation=FormationsContenirCours::where('id_cours',$id_cours)
        ->get();
        foreach($Formation as $f){
          //  $cursus=Formation::where('id',$f->id_formation)->where('nombre_chapitre_total',1)->get();
            $session =  Session::where('formations_id',$f->id_formation)
            ->where('etat',1)
            ->where('statut_id',3)
            ->first();
            if($session!=null /*&& $cursus!=null*/){
                return false;
            }
        }
        return true;
    }
    public function checkCoursSuivreFormation($id_cours){
       $Suivre= Suivre_formation::where("id_cours",$id_cours)->get();
      
      
       foreach($Suivre as $s){
        $cours= FormationsContenirCours::where('id_cours',$id_cours)
        ->where('id_formation',$s->id_formations)->first();
        $coursPrecedent= FormationsContenirCours::where('numero_cours',$cours->numero_cours-1)->where('numero_cours','!=',0)->first();

            if($coursPrecedent!=null){
                $chapitre=Chapitre::where('etat',1)->where('id_cours',$coursPrecedent->id_cours)->where('numero_chapitre',1)->first();
                $s->update([
                    'id_cours' => $coursPrecedent->id_cours,
                    'nombre_chapitre_lu' => $s->nombre_chapitre_lu-1,
                    'id_chapitre' => $chapitre->id_chapitre,
                    'id_chapitre_Courant'=> $chapitre->id_chapitre
                ]);
            } else {
               // dd($cours->numero_cours);
                $s->delete();
            }
       }

    }
}
