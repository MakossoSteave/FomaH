<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\FormationsContenirCours;
use App\Models\Formation;
use App\Models\Cours;
use App\Models\Chapitre;
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

        return view('admin.cours.create', compact(['formations'], 'id'));
    }

    public function filter($id)
    {
        $cours = Cours::select('cours.*', 'formations.libelle', 'formateurs.id as formateurID','formateurs.nom as formateurNom','formateurs.prenom as formateurPrenom')
        ->join('formations_contenir_cours', 'cours.id_cours', '=', 'formations_contenir_cours.id_cours')
        ->join('formations', 'formations.id',"=","formations_contenir_cours.id_formation")
        ->join('formateurs', 'formateurs.id',"=","cours.formateur")
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
        //  'image' => ['mimes:jpeg,png,bmp,tiff,jfif,gif,GIF ','max:10000',
        //          new FilenameImage('/^[a-zA-Z0-9_.-^\s]{4,181}$/')]
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
    $cours = Cours::find($idCours);

    return view('admin.cours.edit',compact(['cours']));
    }

    public function editFilter($idCours, $idFormation)
    {
       $cours = Cours::find($idCours);

       return view('admin.cours.edit',compact(['cours'], ['idFormation']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'designation' => ['required','max:191', Rule::unique('cours')->where(function ($query) use($id) {
             
                return $query->where('id_cours',"!=", $id);
            })] ,
            'prix' => ['required','numeric','min:0'],
            'etat' => [
                'required',
                 Rule::in(['0', '1'])],
                 'image' => ['mimes:jpeg,png,bmp,tiff,jfif,gif,GIF ','max:10000',
                 new FilenameImage('/^[a-zA-Z0-9_.-^\s]{4,181}$/')]
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
        if($etat==1){
            $chapitre =  Chapitre::where('id_cours',$id)
            ->where('etat',1)
            ->count();
            if($chapitre ==0){
                $etat=0;
                $etatCanChange=false;
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
        
                        $Formation->Update_nombre_chapitre_total($f->id_formation,$nombreChapitresCours);
                    }

            }


        
            
        }else {
            $this->Update_cours($id);
            $this->checkEtat($id);
        }
      /*if($etat==1){
          $nbChap= $nombreChapitresCours+1;
      }
      else {
        $nbChap =$nombreChapitresCours; 
      }*/
        Cours::where('id_cours', $id)->update([
            'designation' => $request->get('designation'),
            'image' => $image,
            'prix' => $request->get('prix'),
            'formateur' => $request->get('formateur'),
            'etat' => $etat/*,
            'nombre_chapitres' =>  $nbChap*/
        ]);

        if(!$etatCanChange){
            return redirect('/cours/'.$request->get('formation_id'))->with('success','Cours modifié avec succès')
            ->with('error',"L'état ne peut pas être modifié car aucun chapitre n'est actif ! ");
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
             
        }
    }

    public function etat($id)
    {
        $cours = Cours::find($id);
        $etat = !$cours->etat;
        $etatCanChange=true;
        if($etat==1){
            $chapitre =  Chapitre::where('id_cours',$id)
            ->where('etat',1)
            ->count();
            if($chapitre ==0){
                $etat=0;
                $etatCanChange=false;
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
        
                        $Formation->Update_nombre_chapitre_total($f->id_formation,$nombreChapitresCours);
                    }

               
            }


        }   
        // etat == 0
        else {
            $this->Update_cours($id);
            $this->checkEtat($id);
        }
        //

        //return
        if(!$etatCanChange){
            return redirect()->back()->with('error',"L'état ne peut pas être modifié car aucun chapitre n'est actif ! "); 
        }
        else {
        Cours::where('id_cours', $id)->update(array('etat' => $etat));
        return redirect()->back()->with('success','Modifié avec succès');
    }
    }
    public function destroy($id)
    {
       
        // toutes les id formations qui contienent le cours
        $this->checkEtat($id);
       
        
        /*************************** */

        // nombre de chapitres du cours
        $nombreChapitresCours=Cours::where('id_cours',$id)->value('nombre_chapitres');
        $Formation= new FormationAdminController;

        $cours = Cours::find($id);
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
            FormationsContenirCours::where('id_formation',$f->id_formation)
            ->where("numero_cours",">",$f->numero_cours)
            ->decrement('numero_cours',1);
        }

         /*************************** */

        // Supprimer le cours
        Cours::where('id_cours',$id)->delete();

        return redirect()->back()->with('success','Cours supprimé avec succès');
    }
    public function checkEtat($id){
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

        if( $cours==0){

 Formation::where('id',$c->id_formation)->update([
                    
                    'etat' => 0
                   
                ]);}
        }
         
    }
}
