<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;




use App\Models\Competence;
USE App\Models\Categorie;
use Illuminate\Validation\Rules\Exists;

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
        $utilisateurID = Auth::user()->id;
        $formateur= new FormateurController;
        $formateurID= $formateur->findFormateurID($utilisateurID); 
        
        $sousmatiere = $request->get('sousmatiere');

        if( Competence::select('id_sous_matiere')
        ->where('id_formateur','=',$formateurID)
        ->where('id_sous_matiere','=',$sousmatiere)
        ->exists()){
            return redirect('dropdownn/'.intval([Auth::user()->id]))->with('warning','Cette compétence est déjà déclarée');
        }
        if($request->get('categorie')=="Sélectionner une catégorie"){
            return redirect('dropdownn/'.intval([Auth::user()->id]))->with('danger',"Vous n'avez pas sélectionné de catégorie" );
        }
        if($request->get('matiere')=="Sélectionner une matière"){
            return redirect('dropdownn/'.intval([Auth::user()->id]))->with('danger',"Vous n'avez pas sélectionner de matière" );
        }
        if($request->get('sousmatiere')=="Sélectionner une sous matière"){
            return redirect('dropdownn/'.intval([Auth::user()->id]))->with('danger',"Vous n'avez pas sélectionner de sous matière" );
        }
        /*
        echo "ici  :";
        dd($deja);
        echo " // ";
        */

        do {
            $id = rand(10000000, 99999999);
        } while(Competence::find($id) != null);
        
        //var_dump($request->get('userId'));
               
         
        //var_dump($utilisateurID);
        //var_dump($formateurID);
        //var_dump($id);

        //dd($request->get('categorie'));
        //dd($request->get('matiere'));
        //dd($request->get('sousmatiere'));


        

        $succes = Competence::create([
            'id' => $id,
            'id_formateur' => $formateurID,
            'id_categorie' => $request->get('categorie'),
            'id_matiere' => $request->get('matiere'),
            'id_sous_matiere' => $request->get('sousmatiere'),      
        ]);

        //dd($succes);
        
        
        if(isset($succes)) {
            return redirect('dropdownn/'.intval([Auth::user()->id]))->with('success','La compétence a été ajouté avec succès');
            } 
                        //<a href="{{ route('dropdownn', [Auth::user()->id]) }}">
           
            /*
            if(isset($succes)) {
                return redirect('/cours/'.intval($request->get('formation_id')))->with('success','Le cours a été ajouté avec succès');
                } else {
                    return redirect('/cours')->with('success','Cours créé avec succès');

                }   
        */

       

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
