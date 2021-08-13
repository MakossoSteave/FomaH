<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matiere;
use App\Models\Categorie;
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
        $sousmatieres = DB::table("sous_matieres")->where('matiere_id',$request->matiere_id)->get();  
        //dd($sousmatieres);      
        return view('admin.sous_matiere.index',compact(['sousmatieres'])); 
    }
    public function categoriematiereetsous(Request $request)
    {
        $categories = DB::table("categories")->get();  
        $matieres = DB::table("matieres")->get();             
        return view('admin.sous_matiere.categoriematiereetsous',compact(['categories'])); 
    }
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        SousMatiere::where('id',$id)->delete();
        return redirect()->back()->with('success','Sous Matière supprimée avec succès');

    }
}
