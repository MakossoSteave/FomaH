<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapitre;
use App\Models\Cours;
use App\Http\Controllers\CoursController;
use App\Models\FormationsContenirCours;
//use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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
         'designation' => ['required', Rule::unique('chapitres')->where(function ($query) use($idCours) {
             
            return $query->where('id_cours', $idCours);
        })] ,
         'video' => 'required|mimes:mp4,mov,ogg,qt |max:2097152',
         'image' => 'mimes:jpeg,png,bmp,tiff,jfif |max:10000'
        ]);
      do {
            $id_chapitre = rand(10000000, 99999999);
        } while((Chapitre::find($id_chapitre))!=null);
       // Chapitre::where
        $Cours = new CoursController;
        
        $numero_chapitre=((Cours::where('id_cours',$idCours)->value('nombre_chapitres')));//numero chapitre = nombre chapitre total cours+1
        $Cours->Update_nombre_chapitres($idCours,1);//ajouter +1 au nombre total de chapitre cours
        $Formation = new FormationAdminController;
        $FindCours=FormationsContenirCours::where('id_cours',$idCours)->first();
        if($FindCours!=null){
        $Formation->Update_nombre_chapitre_total(FormationsContenirCours::where('id_cours',$idCours)->value('id_formation'),1);
        }

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
        $Cours = Chapitre::find($id_chapitre);
        $idCours = $Cours->id_cours;
        $request->validate([
         'designation' => ['required', Rule::unique('chapitres')->where(function ($query) use($idCours,$id_chapitre){
             
            return $query->where('id_cours', $idCours)
            ->where('id_chapitre',"!=", $id_chapitre);
        })] ,
            'etat' => [
                'required',
                 Rule::in(['0', '1'])],
            'image' => 'mimes:jpeg,png,bmp,tiff,jfif |max:10000',
            'video' => 'mimes:mp4,mov,ogg,qt |max:2097152'
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
        Chapitre::where('id_chapitre', $id_chapitre)->update(array('etat' => $etat));
        return redirect()->back()->with('success','Modifié avec succes');
    }
    public function destroy($id_chapitre)
    {
        $Chapitre= Chapitre::find($id_chapitre);
        Chapitre::where('id_chapitre',$id_chapitre)->delete();
        $Cours = new CoursController;
        $Cours->Update_nombre_chapitres($Chapitre->id_cours,-1);//ajouter +1 au nombre total de chapitre cours
        $Formation = new FormationAdminController;
        $FindCours=FormationsContenirCours::where('id_cours',$Chapitre->id_cours)->count();
        if($FindCours!=0){
        $Formation->Update_nombre_chapitre_total(FormationsContenirCours::where('id_cours',$Chapitre->id_cours)->value('id_formation'),-1);
        }
        Chapitre::where('id_cours',$Chapitre->id_cours)
            ->where("numero_chapitre",">",$Chapitre->numero_chapitre)
            ->decrement('numero_chapitre',1);
        return redirect()->back()->with('success','Supprimé avec succes');
    }

}