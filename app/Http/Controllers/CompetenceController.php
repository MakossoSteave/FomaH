<?php

namespace App\Http\Controllers;

use App\Models\Competence;
USE App\Models\Categorie;
use Brick\Math\BigInteger;
use Illuminate\Http\Request;

class CompetenceController extends Controller
{
    /**
     * Display a listing of the resource.
     * Afficher une liste de la ressource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Categorie::all();
                   
        return view('admin.categorie.index',compact(['categories']));
    }

    /**
     * Show the form for creating a new resource.
     * Affichez le formulaire de création d'une nouvelle ressource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $resultat = "ceci sont des données du formulaire : la matiere ".request('matiere')." puis : la sous matiere ".request('sousmatiere')." et enfin la categorie ".request('categorie');

        return $resultat;

    }

    /**
     * Store a newly created resource in storage.
     * Stockez une ressource nouvellement créée dans le stockage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        //Competence::create($request->all());
        //dd($request);
        //var_dump($request->get('userId'));
        //var_dump($request->get('categorie'));
        var_dump($request->get('userId'));
        $integer = intval($request->get('userId'));
        //$str = $request->get('userId');
        var_dump($integer);
        
        

        //var_dump($request->get('matiere'));
        //var_dump($request->get('sousmatiere'));
        

        Competence::create([
            'id_formateur' => $request->get($integer),
            'id_categorie' => $request->get('categorie'),
            'id_matiere' => $request->get('categorie'),
            'id_sous_matiere' => $request->get('categorie'),      
        ]);
        

       

    }

    /**
     * Display the specified resource.
     * Affiche la ressource spécifiée.
     *
     * @param  \App\Models\Competence  $competence
     * @return \Illuminate\Http\Response
     */
    public function show(Competence $competence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * Affiche le formulaire de modification de la ressource spécifiée.
     *
     * @param  \App\Models\Competence  $competence
     * @return \Illuminate\Http\Response
     */
    public function edit(Competence $competence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Competence  $competence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Competence $competence)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * Supprime la ressource spécifiée du stockage.
     *
     * @param  \App\Models\Competence  $competence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Competence $competence)
    {
        //
    }
}
