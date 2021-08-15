<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class MatiereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   

        $designation_categorie = DB::table("categories")->where('id',$request->categorie_id)->value('designation');
        
        $matieres = DB::table("matieres")->where('categorie_id',$request->categorie_id)->get();  
        
        //dd($designation_categorie,$matieres);

        return view('admin.matiere.index',compact(['matieres','designation_categorie'])); 
    }
    public function categoriematiere(Request $request)
    {
        $categories = DB::table("categories")->get();             
        return view('admin.matiere.categoriematiere',compact(['categories'])); 
    }
    public function listematiere(Request $request)
    {
        $matieres = DB::table("matieres")->where('categorie_id',$request->categorie_id)->get();    
        return view('admin.matiere.index',compact(['matieres'])); 
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = DB::table("categories")->pluck("designation","id");
        return view('admin.matiere.create',compact(['categories']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        //dd($request->get('designation_matiere'));
        $name1 = $request->get('categorie_id');
        $name2 = "Sélectionner une catégorie";
        //dd($name1, $name2);
        $request->validate(['designation_matiere' => ['required','unique:matieres','max:191']]);

        if($name1 != $name2){
            
        

            do {
                $id = rand(10000000, 99999999);
            } while(Matiere::find($id) != null); 

            Matiere::create($request->all()+['id' => $id]);
            $string = 'Matiere: '.$request->get('designation_matiere').' créée avec succès';
            
            return redirect()->back()->with('success',$string);

        }
        return redirect()->back()->with('warning','vous n\' avez pas sélectionné de catégorie, c\'est un champ obligatoire pour créer une matière');
    }
    
     
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $matiere = Matiere::find($id);
        return view('admin.matiere.edit',compact(['matiere']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        //dd($request);
        $request->validate([
            'designation_matiere' => ['required','max:191', Rule::unique('matieres')->where(function ($query) use($id) {         
                return $query->where('id',"!=", $id);
            })]
        ]);
        Matiere::where('id', $id)->update(['designation_matiere' => $request->get('designation_matiere')]);
        return redirect('/categoriematiere')->with('success','Matière modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request , $id)
    {
        //dd($id);
        $b = DB::table('sous_matieres')->where('matiere_id',$id)->exists();

        if($b){
            return redirect()->back()->with('danger','LA SUPPRESSION A ECHOUE, une matière ne peut pas être supprimée 
            si elle posséde une sous_matière, vous devez supprimer la ou les sous_matière(s) lié(es) à cette matière.');
        }
        $designation_matiere = DB::table('matieres')->where('id',$id)->value('designation_matiere');
        
        
        Matiere::where('id',$id)->delete();

        return redirect()->back()->with('success','Matière '.$designation_matiere.' supprimée avec succès');
    }
}


        