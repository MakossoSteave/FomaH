<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Categorie;



use App\Models\Competence;


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
        $utilisateurID = Auth::user()->id;
        $formateur= new FormateurController;
        $formateurID= $formateur->findFormateurID($utilisateurID); 

                    $categories = DB::table('categories')->get();
                    //dd($categories);

 

                    $competences = DB::table('competences')  
                                    ->join('categories','id_categorie', '=','categories.id')
                                    ->join('matieres','id_matiere', '=','matieres.id')
                                    ->join('sous_matieres','id_sous_matiere', '=','sous_matieres.id')
                                    ->where('id_formateur', '=', $formateurID)
                                    ->select('competences.id as competence_id','categories.designation as designation_ca','designation_matiere as designation_ma',
                                            'designation_sous_matiere as designation_s_ma')
                                    ->orderBy('id_categorie')
                                    ->orderBy('id_matiere')
                                    ->orderBy('id_sous_matiere')
                                    ->get();
        //var_dump($competences);
        //dd($competences);                        

                               
        return view('formateur.competence',compact('competences','categories'));
        //return view('admin.cours.filter', compact(['cours']),["FormationID" => $id]);
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
        //var_dump($utilisateurID);
        //dd($request->get('categorie'));
        
        */

        do {
            $id = rand(10000000, 99999999);
        } while(Competence::find($id) != null);
          

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

    
    public function destroy($id)
    {
        Competence::where('id',$id)->delete();
        return redirect('/competence')->with('success','Compétence supprimée avec succès');
    }
    

    /*
    public function destroy($id)
    {
        Categorie::where('id',$id)->delete();

        return redirect('/categorie')->with('success','Categorie supprimé avec succès');
    }
    */
}
