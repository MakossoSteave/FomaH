<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matiere;
use App\Models\Categorie;
use App\Models\Competence;
use App\Models\SousMatiere;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SousMatiereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd($request);
        $designation_categorie = DB::table("categories")->where('id',$request->categorie_id)->value('designation');
        $designation_matiere = DB::table("matieres")->where('id',$request->matiere_id)->value('designation_matiere');

        $sousmatieres = DB::table("sous_matieres")->where('matiere_id',$request->matiere_id)->get();
        //dd($designation_categorie);
        //dd($designation_matiere);
        //dd($sousmatieres);      
        return view('admin.sous_matiere.index',compact(['sousmatieres','designation_categorie','designation_matiere'])); 
    }
    public function categoriematiereetsous(Request $request)
    {
        $categories = DB::table("categories")->get();             
        return view('admin.sous_matiere.categoriematiereetsous',compact(['categories'])); 
    }
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = DB::table("categories")->pluck("designation","id");
        //$categories = DB::table("categories")->get();
        return view('admin.sous_matiere.create',compact(['categories']));
        
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
        $name1 = $request->get('matiere_id');
        $name2 = "Sélectionner une matière";
        $request->validate(['designation_sous_matiere' => ['required','unique:sous_matieres','max:191']]);
        //dd($name1,$name2);

        if($name1 != $name2){

            do {
                $id = rand(10000000, 99999999);
            } while(DB::table('sous_matieres')->where('id', $id)->exists());
            

            //(Matiere::find($id) != null); 
            SousMatiere::create($request->all()+['id' => $id]);
            $string = 'Sous-matiere: '.$request->get('designation_sous_matiere').' créée avec succès';

            return redirect()->back()->with('success',$string);
            
        }
        //dd($request);
        return redirect()->back()->with('warning','vous n\' avez pas sélectionné de matière, c\'est un champ obligatoire pour créer une sous-matière');
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
        $sousmatiere = SousMatiere::find($id);
        return view('admin.sous_matiere.edit',compact(['sousmatiere']));
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
        $request->validate([
            'designation_sous_matiere' => ['required','max:191', Rule::unique('sous_matieres')->where(function ($query) use($id) {         
                return $query->where('id',"!=", $id);
            })]
        ]);
        SousMatiere::where('id', $id)->update(['designation_sous_matiere' => $request->get('designation_sous_matiere')]);
        return redirect('/categoriematiereetsous')->with('success','Sous matière modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('competences')->where('id_sous_matiere',$id)->delete();
        SousMatiere::where('id',$id)->delete();

        return redirect()->back()->with('success','Sous Matière supprimée avec succès');

    }
}
