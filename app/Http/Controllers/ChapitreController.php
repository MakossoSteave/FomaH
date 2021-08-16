<?php

namespace App\Http\Controllers;

use App\Models\Chapitre;
use App\Models\Section;
use App\Models\Cours;
use App\Models\Session;
use App\Http\Controllers\CoursController;
use App\Models\Formation;
use App\Models\FormationsContenirCours;

use Illuminate\Http\Request;
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
    
    public function create()
    {   
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
      
          new FilenameVideo('/[\w\W]{4,181}$/')],
          'image' => ['mimes:jpeg,png,bmp,tif,gif,ico,jpg,GIF','max:10000',
          new FilenameImage('/[\w\W]{4,181}$/')],
          'etat' => [
              'required',
               Rule::in(['0', '1'])]
        ]);

        do {
            $id_chapitre = rand(10000000, 99999999);
        } while((Chapitre::find($id_chapitre))!=null);
       // Chapitre::where

        $Cours = new CoursController;
        if($request->get('etat')==1){
            $numero_chapitre=
            Chapitre::where('id_cours',$idCours)->where('etat',1)->count();
        }
        else {
            $numero_chapitre=
            Chapitre::where('id_cours',$idCours)->count();
        }

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
       
        Chapitre::create(['designation' => $request->get('designation')] + ['numero_chapitre' => $numero_chapitre+1] + ['id_chapitre' => $id_chapitre]+['video'=>$video]+['image'=>$image]+['etat'=> $request->get('etat')]+['id_cours'=>$idCours]);
        // $this->etat($id_chapitre);

            if ($request->has('section')) {
                for ($idSect=0; $idSect < count($request->get('section')); $idSect++) { 

                    // $request->validate([
                    //     'designation' => ['required','max:191', Rule::unique('sections')->where(function ($query) use($request) {
                        
                    //         return $query->where('id_chapitre', $request->get('id_chapitre'));})] ,
                    // 'contenu' => ['required','max:5000'],
                    // 'image' => ['mimes:jpeg,png,bmp,tif,gif,ico,jpg,GIF ','max:10000',
                    // new FilenameImage('/[\w\W]{4,181}$/')]
                    // ]);
                    // $request->validate([
                    //        "section[$idSect][designation]" => 'required',
                    //        "section[$idSect][contenu]" => 'required'
                    // ]);

                    do {
                        $idSection = rand(10000000, 99999999);
                    } while(Section::find($idSection) != null);

                    if ($request->hasFile("section.$idSect.image")) {
                        $destinationPath = public_path('img/section/');
                        $file = $request->file("section.$idSect.image");
                        $filename = $file->getClientOriginalName();
                        $image = time().$filename;
                        $file->move($destinationPath, $image);
                    } else {
                        $image = null;
                    }    

                    Section::create([
                        'id' => $idSection,
                        'designation' => $request->section[$idSect]['designation'],
                        'contenu' => $request->section[$idSect]['contenu'],
                        'image' => $image,
                        'etat' => 1,
                        'id_chapitre' => $id_chapitre
                    ]);
                }
            }
            
        return redirect('/chapitres/'.intval($request->session()->get('idCours')))->with('success','Chapitre créé avec succès');
    }

    // public function show($id_chapitre)
    // {
    //    $data =  Chapitre::find($id_chapitre);

    //    return view('chapitre.show',compact(['data']));
    // }

    public function edit($id_chapitre)
    {
       $chapitre = Chapitre::where('id_chapitre', $id_chapitre)->with(['Section' => function($query) use($id_chapitre) {
        $query->where('sections.id_chapitre', $id_chapitre);
    }])->get();

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
                 new FilenameVideo('/[\w\W]{4,181}$/')],
                 'image' => ['mimes:jpeg,png,bmp,tif,gif,ico,jpg,GIF ','max:10000',
                 new FilenameImage('/[\w\W]{4,181}$/')]
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
        $etat=$request->get('etat');
        if($etat){
            if(!$this->checkChapitre($id_chapitre)){
                $etat=1;
                $message="Etat non modifié car une session est active";/*et aucun autre chapitre n'est actif";*/
            } else { $this->updateChapitre($chapitre,"etat");}
           
        } else {
            $Numero= Chapitre::where('id_cours',$idCours)->where('etat',1)->max('numero_chapitre');
            Chapitre::where('id_chapitre',$id_chapitre)->update([
                    
                'numero_chapitre' => $Numero+1
               
            ]);
           
            $CoursController = new CoursController;
                $CoursController->Update_nombre_chapitres($idCours,1);//ajouter +1 au nombre total de chapitre cours
                $cours = Cours::find($idCours);
                if($cours->etat==1){
                    $Formation = new FormationAdminController;
                    //  $FindCours=FormationsContenirCours::where('id_cours',$idCours)->first();
                      $FindFormation=FormationsContenirCours::where('id_cours',$idCours)->get();
                      foreach($FindFormation as $f){
                      $Formation->Update_nombre_chapitre_total($f->id_formation,-1);
                    }
               
                }
            }

        Chapitre::where('id_chapitre',$id_chapitre)->update([
            'designation' => $request->get('designation'),
            'image' => $image,
            'video' => $video,
            'etat' => $etat
        ]); 
        if ($request->has('updateSection')) {

        for ($indexSection=0; $indexSection < count($request->get('updateSection')); $indexSection++) {
            $request->validate([
                "updateSection[$indexSection][designation]" => 'required',
                "updateSection[$indexSection][contenu]" => 'required'
             ]);
            $sectionId = $request->updateSection[$indexSection]['sectionID'];

            // $request->validate([
            //     'designation' => ['required','max:191', Rule::unique('sections')->where(function ($query) use($request, $sectionId) {
            //      return $query->where('id_chapitre', $request->get('id_chapitre'))
            //                  ->where("id","!=",$sectionId);})] ,
            //     'contenu' => ['required','max:5000'],
            //     'etat' => [
            //         'required',
            //          Rule::in(['0', '1'])],
            //          'image' => ['mimes:jpeg,png,bmp,tif,gif,ico,jpg,GIF ','max:10000',
            //          new FilenameImage('/[\w\W]{4,181}$/')]
            // ]);
        
            if ($request->hasFile("updateSection.$indexSection.image")) {
                $destinationPath = public_path('img/section/');
                $file = $request->file("updateSection.$indexSection.image");
                $filename = $file->getClientOriginalName();
                $image = time().$filename;
                $file->move($destinationPath, $image);
            } else {
                $section=Section::find($sectionId);
                $image = $section->image;
            }
    
            Section::where('id', $sectionId)->update([
                'designation' => $request->updateSection[$indexSection]['designation'],
                'contenu' => $request->updateSection[$indexSection]['contenu'],
                'image' => $image,
                'etat' => $request->updateSection[$indexSection]['etat']
            ]);
        }
        }

        if ($request->has('section')) {
            
            for ($idSect=0; $idSect < count($request->get('section')); $idSect++) { 

                // $request->validate([
                //     'designation' => ['required','max:191', Rule::unique('sections')->where(function ($query) use($request) {
                    
                //         return $query->where('id_chapitre', $request->get('id_chapitre'));})] ,
                // 'contenu' => ['required','max:5000'],
                // 'image' => ['mimes:jpeg,png,bmp,tif,gif,ico,jpg,GIF ','max:10000',
                // new FilenameImage('/[\w\W]{4,181}$/')]
                // ]);
                // $request->validate([
                //     "section[$idSect][designation]" => 'required',
                //     "section[$idSect][contenu]" => 'required'
                //  ]);

                do {
                    $idSection = rand(10000000, 99999999);
                } while(Section::find($idSection) != null);

                if ($request->hasFile("section.$idSect.image")) {
                    $destinationPath = public_path('img/section/');
                    $file = $request->file("section.$idSect.image");
                    $filename = $file->getClientOriginalName();
                    $image = time().$filename;
                    $file->move($destinationPath, $image);
                } else {
                    $image = null;
                }    

                Section::create([
                    'id' => $idSection,
                    'designation' => $request->section[$idSect]['designation'],
                    'contenu' => $request->section[$idSect]['contenu'],
                    'image' => $image,
                    'etat' => 1,
                    'id_chapitre' => $id_chapitre
                ]);
            }
        }
        if($message!=null){
            return redirect('/chapitres/'.intval($request->session()->get('idCours')))->with('success','Modifié avec succés')
            ->with('error',$message);
        }else {
            return redirect('/chapitres/'.intval($request->session()->get('idCours')))->with('success','Modifié avec succés');

        }
    }

    public function deleteSection($id)
    {
        Section::where('id',$id)->delete();
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
            if(!$this->checkChapitre($id_chapitre)){
                return redirect()->back()->with('error',"Etat non modifié car une session est active"); /*et aucun autre chapitre n'est actif");*/
            }
            $this->updateChapitre($Chapitre,"etat");
        }else {
            $Numero= Chapitre::where('id_cours',$coursId)->where('etat',1)->max('numero_chapitre');
            Chapitre::where('id_chapitre',$id_chapitre)->update([
                    
                'numero_chapitre' => $Numero+1
               
            ]);
            /*$testChapitre = Chapitre::where('numero_chapitre',$Chapitre->numero_chapitre)->where('id_cours',$coursId)->where('id_chapitre','!=',$id_chapitre)->where('etat',1)->get();
            if($testChapitre!=null){
            $ChapitreMin =  Chapitre::where('numero_chapitre',$Chapitre->numero_chapitre)->where('id_cours',$coursId)->min('created_at');
            $chap=  Chapitre::where('numero_chapitre',$Chapitre->numero_chapitre)->where('id_cours',$coursId)->where('created_at',$ChapitreMin)->value('id_chapitre');*/
            $CoursController = new CoursController;
                $CoursController->Update_nombre_chapitres($Chapitre->id_cours,1);//ajouter +1 au nombre total de chapitre cours
                $Formation = new FormationAdminController;
                $cours = Cours::find($Chapitre->id_cours);
                if($cours->etat==1){
                $FindFormation=FormationsContenirCours::where('id_cours',$Chapitre->id_cours)->get();
                foreach($FindFormation as $f){
                $Formation->Update_nombre_chapitre_total($f->id_formation,1);
                }
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
        return redirect()->back()->with('success','Etat modifié avec succès');
    }

    public function destroy($id_chapitre)
    {
        if(!$this->checkChapitre($id_chapitre)){
            return redirect()->back()->with('error',"Ne peut pas être supprimé car une session est active");/* et aucun autre chapitre n'est actif");*/
        }
        else {
            $Chapitre= Chapitre::find($id_chapitre);
        
            $coursId=  $Chapitre->id_cours;
           // $this->checkEtat($coursId,$id_chapitre);
           
            Chapitre::where('id_chapitre',$id_chapitre)->delete();
    
            //update numero chapitre
           // if($Chapitre->etat==1){
                $this->updateChapitre($Chapitre,null);
            //}
            
            //
    
            return redirect()->back()->with('success','Supprimé avec succès');
        }
        
    }
    public function checkChapitre($id_chapitre){
        $chapitre=Chapitre::find($id_chapitre);
        //$cours=Cours::where('id_cours',$chapitre->id_cours);
        $Formation=FormationsContenirCours::where('id_cours',$chapitre->id_cours)
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
    public function checkEtat($id,$id_chapitre){
        $ChapitreActifCours= Chapitre::where('id_cours',$id)->where('etat',1)->where('id_chapitre',"!=",$id_chapitre)->count();
        if($ChapitreActifCours == 0){
            Cours::where('id_cours',$id)->update([
                
                'etat' => 0
               
            ]);
            $CoursController = new CoursController;
            $CoursController->checkEtat($id,false);
        }
    }

    private function updateChapitre($Chapitre,$etat){
        $CoursController = new CoursController;
        $CoursController->Update_nombre_chapitres($Chapitre->id_cours,-1);//ajouter +1 au nombre total de chapitre cours
        $cours = Cours::find($Chapitre->id_cours);
        if($cours->etat==1){
        $Formation = new FormationAdminController;
        
        $FindFormation=FormationsContenirCours::where('id_cours',$Chapitre->id_cours)->get();
        foreach($FindFormation as $f){
            
        $Formation->Update_nombre_chapitre_total($f->id_formation,-1);
        }
         // Mettre à jour le nombre de cours total dans chaque formations
         $this->checkEtat($Chapitre->id_cours,$Chapitre->id_chapitre); 
         $coursCheckChange = Cours::find($Chapitre->id_cours);
         if($coursCheckChange->etat==0 && $coursCheckChange->etat!=$cours->etat){
            foreach($FindFormation as $f){
            $Formation->Update_nombre_cours_total($f->id_formation,-1);
         }
        }
        
         
        }
        if($etat!=null){
            Chapitre::where('id_cours',$Chapitre->id_cours)
            ->where("numero_chapitre",">",$Chapitre->numero_chapitre)
            ->where("etat",1)
            ->decrement('numero_chapitre',1);
        }else {
            if($Chapitre->etat==1){
                Chapitre::where('id_cours',$Chapitre->id_cours)
                ->where("numero_chapitre",">",$Chapitre->numero_chapitre)
                ->where("etat",1)
                ->decrement('numero_chapitre',1);
            } else {
                Chapitre::where('id_cours',$Chapitre->id_cours)
                ->where("numero_chapitre",">",$Chapitre->numero_chapitre)
                ->where("etat",0)
                ->decrement('numero_chapitre',1);
            }
          
        }
       
    }
}