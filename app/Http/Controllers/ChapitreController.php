<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapitre;
use App\Models\Cours;
use App\Http\Controllers\CoursController;
use App\Models\FormationsContenirCours;
class ChapitreController extends Controller
{
    private $idCours;
    public function index()
    {
        $chapitres = Chapitre::all() ->orderBy('created_at','asc')
        ->paginate(5);
        return view('admin.chapitre.index',compact(['chapitres']));
    }

    public function filter(Request $request,$id)
    { /* $chapitre = Chapitre::where("id_cours",$id_Cours)
        ->orderBy('created_at','asc')
        ->paginate(5)/*->setPath('chapitre');
                   
        return view('chapitre.index',compact(['chapitre']));*/ 
        $request->session()->put('idCours', $id);
        $this->idCours=$id;
        $chapitres = Chapitre::where('id_cours', $id)
        ->orderBy('numero_chapitre','asc')
        ->paginate(5);          
        return view('admin.chapitre.filter',compact(['chapitres']),['idCours' => $request->session()->get('idCours')]);
    }
    
    public function create(Request $request)
    {
        
       // $this->idCours=$id;
        
        return view('admin.chapitre.create');
    }

    public function store(Request $request)
    {
        $request->validate([
         'designation' => 'required',
         'video' => 'required'
        ]);
      do {
            $id_chapitre = rand(10000000, 99999999);
        } while((Chapitre::where("id_chapitre",$id_chapitre))->count()!=0);
        $Cours = new CoursController;
        $idCours= $request->session()->get('idCours');
        $numero_chapitre=((Cours::where('id_cours',$idCours)->pluck('nombre_chapitres')));//numero chapitre = nombre chapitre total cours+1
        $Cours->Update_nombre_chapitres($idCours,1);//ajouter +1 au nombre total de chapitre cours
        $Formation = new FormationAdminController;
        $Formation->Update_nombre_chapitre_total(FormationsContenirCours::where('id_cours',$idCours)->value('id_formation'),1);

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
       
        Chapitre::create(['designation' => $request->get('designation')] + ['numero_chapitre' => $numero_chapitre[0]+1] + ['id_chapitre' => $id_chapitre]+['video'=>$video]+['image'=>$image]+['etat'=>0]+['id_cours'=>$idCours]);
        // $this->etat($id_chapitre);
        return redirect()->back()->with('success','Create Successfully');
    }

    // public function show($id_chapitre)
    // {
    //    $data =  Chapitre::find($id_chapitre);

    //    return view('chapitre.show',compact(['data']));
    // }

    public function edit($id_chapitre)
    {
       $data = Chapitre::find($id_chapitre);
      

       return view('admin.chapitre.edit',compact(['data']));
    }

    public function update(Request $request, $id_chapitre)
    {
        $request->validate([
            'designation' => 'required',
            'video' => 'required',
            'id_cours' => 'required',
            'etat' => 'required'
        ]);

        Chapitre::where('id_chapitre',$id_chapitre)->update($request->all());   
        return redirect()->back()->with('success','Modifié avec succes');
        
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
        Chapitre::where('id_chapitre',$id_chapitre)->delete();
        return redirect()->back()->with('success','Supprimé avec succes');
    }

}