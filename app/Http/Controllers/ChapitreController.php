<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapitre;
use App\Models\Cours;
use App\Http\Controllers\CoursController;
use App\Models\FormationsContenirCours;
//use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Rules\FilenameImage;
use App\Rules\FilenameVideo;
class ChapitreController extends Controller
{
 
    public function index(Request $request,$id)
    {
        $request->session()->put('idCours', $id);

        $this->idCours=$id;

        $chapitres = Chapitre::where('id_cours', $id)
        ->orderBy('numero_chapitre','asc')
        ->paginate(5);  

        return view('admin.chapitre.index',compact(['chapitres']),['idCours' => $request->session()->get('idCours')]);
    }
    
    public function create(Request $request)
    {
        
       // $this->idCours=$id;
        
        return view('admin.chapitre.create');
    }

    public function store(Request $request)
    {
        $idCours = $request->session()->get('idCours');
        $this->CoursID = $idCours;
        $request->validate([
         'designation' => ['required','max:191', Rule::unique('chapitres')->where(function ($query) use($idCours) {
             
            return $query->where('id_cours', $idCours);
        })] ,
         'video' => ['required','mimes:mp4,mov,ogg,qt ','max:2097152',
      
         new FilenameVideo('/^[a-zA-Z0-9_.-^\s]{4,181}$/')],
         'image' => ['mimes:jpeg,png,bmp,tiff,jfif,gif,GIF ','max:10000',
         new FilenameImage('/^[a-zA-Z0-9_.-^\s]{4,181}$/')]
        ]);
      do {
            $id_chapitre = rand(10000000, 99999999);
        } while((Chapitre::find($id_chapitre))!=null);
       // Chapitre::where
     $Cours = new CoursController;
        
        $numero_chapitre=
        Chapitre::where('id_cours',$idCours)->count();
       // ((Cours::where('id_cours',$idCours)->value('nombre_chapitres')));//numero chapitre = nombre chapitre total cours+1
       /*    $Cours->Update_nombre_chapitres($idCours,1);//ajouter +1 au nombre total de chapitre cours
        $Formation = new FormationAdminController;
        $FindCours=FormationsContenirCours::where('id_cours',$idCours)->first();
        if($FindCours!=null){
        $Formation->Update_nombre_chapitre_total(FormationsContenirCours::where('id_cours',$idCours)->value('id_formation'),1);
        }*/

        if ($request->hasFile('image')) {
            $destinationPath = public_path('img/chapitre/');
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $image = time().$filename;
            $file->move($destinationPath, $image);
        } else {
            $image = $request->get('image-link');
        }
       
            $destinationPathVideo = public_path('video/chapitre/');
            $fileVideo = $request->file('video');
            $filenameVideo = $fileVideo->getClientOriginalName();
            $video = time().$filenameVideo;
            $fileVideo->move($destinationPathVideo, $video);
       
        Chapitre::create(['designation' => $request->get('designation')] + ['numero_chapitre' => $numero_chapitre+1] + ['id_chapitre' => $id_chapitre]+['video'=>$video]+['image'=>$image]+['etat'=>0]+['id_cours'=>$idCours]);
        // $this->etat($id_chapitre);
        
        return redirect('/chapitres/'.intval($request->session()->get('idCours')))->with('success','Chapitre créé avec succès');
    }

    // public function show($id_chapitre)
    // {
    //    $data =  Chapitre::find($id_chapitre);

    //    return view('chapitre.show',compact(['data']));
    // }

    public function edit($id_chapitre)
    {
       $chapitre = Chapitre::find($id_chapitre);
      

       return view('admin.chapitre.edit',compact(['chapitre']));
    }

    public function update(Request $request, $id_chapitre)
    {
        $chapitre = Chapitre::find($id_chapitre);
        $idCours = $chapitre->id_cours;
        $request->validate([
         'designation' => ['required','max:191', Rule::unique('chapitres')->where(function ($query) use($idCours,$id_chapitre){
             
            return $query->where('id_cours', $idCours)
            ->where('id_chapitre',"!=", $id_chapitre);
        })] ,
            'etat' => [
                'required',
                 Rule::in(['0', '1'])],
                 'video' => ['mimes:mp4,mov,ogg,qt ','max:2097152',
                 new FilenameVideo('/^[a-zA-Z0-9_.-^\s]{4,181}$/')],
                 'image' => ['mimes:jpeg,png,bmp,tiff,jfif,gif,GIF ','max:10000',
                 new FilenameImage('/^[a-zA-Z0-9_.-^\s]{4,181}$/')]
        ]);
        if ($request->hasFile('image')) {
            $destinationPath = public_path('img/chapitre/');
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $image = time().$filename;
            $file->move($destinationPath, $image);
        } else {
            $chapitre=Chapitre::find($id_chapitre);
            $image = $chapitre->image;
        }
        if ($request->hasFile('video')) {
            $destinationPathVideo = public_path('video/chapitre/');
            $fileVideo = $request->file('video');
            $filenameVideo = $fileVideo->getClientOriginalName();
            $video = time().$filenameVideo;
            $fileVideo->move($destinationPathVideo, $video);
        } else {
            $chapitre=Chapitre::find($id_chapitre);
            $video = $chapitre->video;
        }

        if($request->get('etat')==0){
            $this->checkEtat($idCours,$id_chapitre);
            $this->updateNumeroChapitre($chapitre,"etat");
        } else {
            $Numero= Chapitre::where('id_cours',$idCours)->where('etat',1)->max('numero_chapitre');
            Chapitre::where('id_chapitre',$id_chapitre)->update([
                    
                'numero_chapitre' => $Numero+1
               
            ]);
           
            $Cours = new CoursController;
                $Cours->Update_nombre_chapitres($idCours,1);//ajouter +1 au nombre total de chapitre cours
                $Formation = new FormationAdminController;
              //  $FindCours=FormationsContenirCours::where('id_cours',$idCours)->first();
                $FindFormation=FormationsContenirCours::where('id_cours',$idCours)->get();
                foreach($FindFormation as $f){
                $Formation->Update_nombre_chapitre_total($f->id_formation,-1);
                }

        
            }
        

        Chapitre::where('id_chapitre',$id_chapitre)->update([
            'designation' => $request->get('designation'),
            'image' => $image,
            'video' => $video,
            'etat' => $request->get('etat')
        ]);   
        return redirect('/chapitres/'.intval($request->session()->get('idCours')))->with('success','Modifié avec succes');
        
    }
    public function Update_numero_chapitre($id_chapitre,$operation)
    {
        $Chapitre = Chapitre::find($id_chapitre);
        $numero_chapitre = $Chapitre->numero_chapitre+$operation;
        if($numero_chapitre<0) $numero_chapitre=0;
        Chapitre::where('id_chapitre', $id_chapitre)->update(array('numero_chapitre' => $numero_chapitre));
    }
    public function etat($id_chapitre)
    {
        $Chapitre = Chapitre::find($id_chapitre);
        $etat = !$Chapitre->etat;
        $coursId=  $Chapitre->id_cours;
        if($etat==0){
           
            $this->checkEtat($coursId,$id_chapitre);
            $this->updateNumeroChapitre($Chapitre,"etat");
        }else {
            $Numero= Chapitre::where('id_cours',$coursId)->where('etat',1)->max('numero_chapitre');
            Chapitre::where('id_chapitre',$id_chapitre)->update([
                    
                'numero_chapitre' => $Numero+1
               
            ]);
            /*$testChapitre = Chapitre::where('numero_chapitre',$Chapitre->numero_chapitre)->where('id_cours',$coursId)->where('id_chapitre','!=',$id_chapitre)->where('etat',1)->get();
            if($testChapitre!=null){
            $ChapitreMin =  Chapitre::where('numero_chapitre',$Chapitre->numero_chapitre)->where('id_cours',$coursId)->min('created_at');
            $chap=  Chapitre::where('numero_chapitre',$Chapitre->numero_chapitre)->where('id_cours',$coursId)->where('created_at',$ChapitreMin)->value('id_chapitre');*/
            $Cours = new CoursController;
                $Cours->Update_nombre_chapitres($Chapitre->id_cours,1);//ajouter +1 au nombre total de chapitre cours
                $Formation = new FormationAdminController;
                $FindFormation=FormationsContenirCours::where('id_cours',$Chapitre->id_cours)->get();
                foreach($FindFormation as $f){
                $Formation->Update_nombre_chapitre_total($f->id_formation,1);
                }

          /*  if($chap==$id_chapitre){
                
                Chapitre::where('id_cours',$coursId)
                    ->where("numero_chapitre",'>=',$Chapitre->numero_chapitre)
                    ->where('id_chapitre',"!=",$id_chapitre)
                    ->where('etat',1)
                    ->increment('numero_chapitre',1);
            }
            else {
            
                Chapitre::where('id_cours',$coursId)
                ->where("numero_chapitre",">",$Chapitre->numero_chapitre)
                ->where('etat',1)
                ->increment('numero_chapitre',1);  
            }
            }*/
            }
        Chapitre::where('id_chapitre', $id_chapitre)->update(array('etat' => $etat));
        return redirect()->back()->with('success','Modifié avec succes');
    }
    public function destroy($id_chapitre)
    {
        $Chapitre= Chapitre::find($id_chapitre);
        
        $coursId=  $Chapitre->id_cours;
        $this->checkEtat($coursId,$id_chapitre);
       
        Chapitre::where('id_chapitre',$id_chapitre)->delete();

        //update numero chapitre
       // if($Chapitre->etat==1){
            $this->updateNumeroChapitre($Chapitre,null);
        //}
        
        //

        return redirect()->back()->with('success','Supprimé avec succes');
    }
    public function checkEtat($id,$id_chapitre){
        $ChapitreActifCours= Chapitre::where('id_cours',$id)->where('etat',1)->where('id_chapitre',"!=",$id_chapitre)->count();
        if($ChapitreActifCours == 0){
            Cours::where('id_cours',$id)->update([
                
                'etat' => 0
               
            ]);
            $CoursController = new CoursController;
            $CoursController->checkEtat($id);
        }
    }
    private function updateNumeroChapitre($Chapitre,$etat){
        $Cours = new CoursController;
        $Cours->Update_nombre_chapitres($Chapitre->id_cours,-1);//ajouter +1 au nombre total de chapitre cours
        $Formation = new FormationAdminController;
        $FindFormation=FormationsContenirCours::where('id_cours',$Chapitre->id_cours)->get();
        foreach($FindFormation as $f){
        $Formation->Update_nombre_chapitre_total($f->id_formation,-1);
        }
        if($etat!=null){
            Chapitre::where('id_cours',$Chapitre->id_cours)
            ->where("numero_chapitre",">",$Chapitre->numero_chapitre)
            ->where("etat",1)
            ->decrement('numero_chapitre',1);
        }else {
            Chapitre::where('id_cours',$Chapitre->id_cours)
            ->where("numero_chapitre",">",$Chapitre->numero_chapitre)
            ->decrement('numero_chapitre',1);
        }
       
    }
}