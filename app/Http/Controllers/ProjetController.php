<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Document;
use App\Models\Projet;
use App\Models\Statut;
use App\Models\ContenirDocumentsProjet;


class ProjetController extends Controller
{
    public function index($id)
    {
        $projets = Projet::select('projets.*', 'formateurs.id as formateurID','formateurs.nom as formateurNom','formateurs.prenom as formateurPrenom')
        ->leftJoin('formateurs', 'formateurs.id',"=","projets.formateur_id")
        ->where('projets.id_cours',$id)
        ->orderBy('created_at','desc')
        ->paginate(5);

        return view('admin.projet.index', compact(['projets']));
    }

    public function create($id)
    {
        return view('admin.projet.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required'
        ]);

        do {
            $idProjet = rand(10000000, 99999999);
        } while(Projet::find($idProjet) != null);

        $utilisateurID = Auth::user()->id;
        $formateur= new FormateurController;
        $formateurID= $formateur->findFormateurID($utilisateurID);  

        Projet::create([
            'id' => $idProjet,
            'description' => $request->get('description'),
            'etat' => 0,
            'formateur_id' => $formateurID,
            'id_cours' => $request->get('id_cours')
        ]);

        if ($request->has('documents')) {
                for ($indexDoc=0; $indexDoc < count($request->get('documents')); $indexDoc++) { 

                do {
                    $idDoc = rand(10000000, 99999999);
                } while(Projet::find($idDoc) != null);
        
                if ($request->hasFile("documents.$indexDoc.lien")) {
                    $destinationPath = public_path('doc/projet/');
                    $file = $request->file("documents.$indexDoc.lien");
                    $filename = $file->getClientOriginalName();
                    $lien = time().$filename;
                    $file->move($destinationPath, $lien);
                } else {
                    $lien = null;
                }
        
                Document::create([
                    'id' => $idDoc,
                    'designation' => $request->documents[$indexDoc]['designation'],
                    'lien' => $lien
                ]);
        
                ContenirDocumentsProjet::create([
                    'id_projet' => $idProjet,
                    'id_document' => $idDoc
                ]);
            }
        }
       
        return redirect('/projet/'.intval($request->get('id_cours')))->with('success','Projet ajouté avec succès');
    }

    public function show($id)
    {
       $projet = Projet::find($id);

       return view('admin.projet.show',compact(['projet']));
    }

    public function edit($id)
    {
       $projet = Projet::find($id);

       return view('admin.projet.edit',compact(['projet']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required'
        ]);

        Projet::where('id', $id)->update([
            'description' => $request->get('description'),
            'etat' => $request->get('etat')
        ]);

        if ($request->has('documentsUpdate')) {
            if ($request->hasFile('lien')) {
                $destinationPath = public_path('doc/projet/');
                $file = $request->file('lien');
                $filename = $file->getClientOriginalName();
                $lien = time().$filename;
                $file->move($destinationPath, $lien);
            } else {
                $document = Document::find($id);
                $lien = $document->lien;
            }

            Document::where('id', $request->get('idDocument'))->update([
                'designation' => $request->get('designation'),
                'lien' => $lien
            ]);
        }

        if ($request->has('documents')) {
            do {
                $idDoc = rand(10000000, 99999999);
            } while(Projet::find($idDoc) != null);
    
            if ($request->hasFile('lien')) {
                $destinationPath = public_path('doc/projet/');
                $file = $request->file('lien');
                $filename = $file->getClientOriginalName();
                $lien = time().$filename;
                $file->move($destinationPath, $lien);
            } else {
                $lien = null;
            }
    
            Document::create([
                'id' => $idDoc,
                'designation' => $request->get('designation'),
                'lien' => $lien
            ]);
    
            ContenirDocumentsProjet::create([
                'id_projet' => $id,
                'id_document' => $idDoc
            ]);
        }

        $idProjet = Projet::where('id',$id)->get();

        return redirect('/projet/'.$idProjet[0]->id_cours)->with('success','Projet modifié avec succès');
    }

    public function destroy($id)
    {
        ContenirDocumentsProjet::where('id_projet', $id)->delete();

        Projet::where('id',$id)->delete();

        return redirect()->back()->with('success','Projet supprimé avec succès');
    }

    public function etat($id)
    {
        $projet = Projet::find($id);
        $etat = !$projet->etat;

        Projet::where('id', $id)->update(array('etat' => $etat));
        return redirect()->back()->with('success','Etat modifié avec succès');
    }
}
