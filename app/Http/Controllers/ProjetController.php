<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Document;
use App\Models\Projet;
use App\Models\ContenirDocumentsProjet;


class ProjetController extends Controller
{
    public function index($id)
    {
        $projets = Projet::where('id_cours', $id)->with('Document')->get();

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
        $idUserAuth=null;
        if(Auth::user())
        $idUserAuth=Auth::user()->id;
        $utilisateurID = $idUserAuth;
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
       $projets = Projet::where('id', $id)->with('Document')->get();

       return view('admin.projet.edit',compact(['projets']));
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
            for ($indexDoc=0; $indexDoc < count($request->get('documentsUpdate')); $indexDoc++) {
                if ($request->hasFile("documentsUpdate.$indexDoc.lien")) {
                    $destinationPath = public_path('doc/projet/');
                    $file = $request->file("documentsUpdate.$indexDoc.lien");
                    $filename = $file->getClientOriginalName();
                    $lien = time().$filename;
                    $file->move($destinationPath, $lien);
                } else {
                    $document = Document::find($request->documentsUpdate[$indexDoc]['documentID']);
                    $lien = $document->lien;
                }

                Document::where('id', $request->documentsUpdate[$indexDoc]['documentID'])->update([
                    'designation' => $request->documentsUpdate[$indexDoc]['designation'],
                    'lien' => $lien
                ]);
            }
        }

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
                'id_projet' => $id,
                'id_document' => $idDoc
            ]);
        }
    }

        $idProjet = Projet::where('id',$id)->get();

        return redirect('/projet/'.$idProjet[0]->id_cours)->with('success','Projet modifié avec succès');
    }

    public function deleteDocument($id)
    {
        ContenirDocumentsProjet::where('id_document', $id)->delete();

        Document::where('id',$id)->delete();
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
