<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;




use App\Models\Competence;
USE App\Models\Categorie;



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
        $resultat = "ceci sont des données du formulaire : la matiere ".request('matiere').
        " puis : la sous matiere ".request('sousmatiere')." et enfin la categorie ".
        request('categorie');

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
        do {
            $id = rand(10000000, 99999999);
        } while(Competence::find($id) != null);
        
        var_dump($request->get('userId'));
               
        $utilisateurID = Auth::user()->id;
        $formateur= new FormateurController;
        $formateurID= $formateur->findFormateurID($utilisateurID);  
        var_dump($utilisateurID);
        var_dump($formateurID);
        var_dump($id);

    

        //var_dump($request->get('matiere'));
        //var_dump($request->get('sousmatiere'));
        

        Competence::create([
            'id' => $id,
            'id_formateur' => $formateurID,
            'id_categorie' => $request->get('categorie'),
            'id_matiere' => $request->get('matiere'),
            'id_sous_matiere' => $request->get('sousmatiere'),      
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
