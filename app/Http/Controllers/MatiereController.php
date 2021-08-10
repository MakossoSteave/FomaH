<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MatiereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $categories = DB::table("categories")->get();
        //$categories = Categorie::all();
        //$categories = DB::table("categories")->pluck("designation","id");
        //return view('dropdownn',compact('categories'));
        $matieres = Matiere::all();
         //dd($categories);          
        return view('admin.matiere.index',compact(['matieres','categories'])); 
    }
    public function indexcategorie(Request $request)
    {
        $matieres = Matiere::all();
        $categories = DB::table("categories")->get();
        //$categories = DB::table("categories")->pluck("designation","id");
         //dd($categories);          
        return view('admin.matiere.indexcategorie',compact(['categories'])); 
    }
    public function listematiere(Request $request)
    {
        $matieres = Matiere::all();
        $categories = DB::table("categories")->get();
        //$categories = DB::table("categories")->pluck("designation","id");
         //dd($categories);          
        return view('admin.matiere.exemple',compact(['categories'])); 
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
        $request->validate([
         'designation_matiere' => ['required','unique:matieres','max:191']
        ]);

        do {
            $id = rand(10000000, 99999999);
        } while(Matiere::find($id) != null); 

        Matiere::create($request->all()+['id' => $id]);
       
        return redirect('/matiere');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
