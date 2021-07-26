<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapitre;
use App\Models\Cours;
use App\Http\Controllers\CoursController;
class ChapitreController extends Controller
{
    public function index()
    {
        $chapitres = Chapitre::all();
                   
        return view('admin.chapitre.index',compact(['chapitres']));
    }

    public function filter($id)
    { /* $chapitre = Chapitre::where("id_cours",$id_Cours)
        ->orderBy('created_at','asc')
        ->paginate(5)/*->setPath('chapitre');
                   
        return view('chapitre.index',compact(['chapitre']));*/ 
        $chapitres = Chapitre::where('id_cours', $id)
        ->orderBy('created_at','asc')
        ->get();          
        return view('admin.chapitre.filter',compact(['chapitres']));
    }
    
    public function create()
    {
        $cours = Cours::all();

        return view('admin.chapitre.create',compact(['cours']));
    }

    public function store(Request $request)
    {
        $request->validate([
         'designation' => 'required',
         'video' => 'required',
         'id_cours' => 'required'
        ]);
        do {
            $id_chapitre = rand(10000000, 99999999);
        } while(Chapitre::where("id_chapitre",$id_chapitre)!=null);
        $Cours = new CoursController;
        $numero_chapitre=($Cours->findCours($request->get('id_cours')->get(['nombre_chapitres']))+1);//numero chapitre = nombre chapitre total cours+1
        $Cours->Update_nombre_chapitres($request->get('id_cours'),1);//ajouter +1 au nombre total de chapitre cours
        Chapitre::create($request->all() + ['numero_chapitre' => $numero_chapitre] + ['id_chapitre' => $id_chapitre]);
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