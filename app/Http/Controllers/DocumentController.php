<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Document;
use App\Models\ContenirDocumentsChapitre;


class DocumentController extends Controller
{
    public function index($id)
    {
        $documents = Document::select('documents.*')
        ->leftJoin('contenir_documents_chapitres', 'contenir_documents_chapitres.id_doc',"=",'documents.id')
        ->where('contenir_documents_chapitres.id_chapitre', $id)
        ->orderBy('created_at','desc')
        ->paginate(5);

        return view('admin.document.index', compact(['documents']));
    }

    public function create($id)
    {
        return view('admin.document.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'designation' => 'required',
            'lien' => 'required'
        ]);

        do {
            $id = rand(10000000, 99999999);
        } while(Document::find($id) != null);
        
        if ($request->hasFile('lien')) {
            $destinationPath = public_path('doc/chapitre/');
            $file = $request->file('lien');
            $filename = $file->getClientOriginalName();
            $lien = time().$filename;
            $file->move($destinationPath, $lien);
        } else {
            $lien = null;
        }

        Document::create([
            'id' => $id,
            'designation' => $request->get('designation'),
            'lien' => $lien
        ]);

        ContenirDocumentsChapitre::create([
            'id_doc' => $id,
            'id_chapitre' => $request->get('id_chapitre')
        ]);
       
        return redirect('/document/'.intval($request->get('id_chapitre')))->with('success','Document ajouté avec succès');
    }

    public function show($id)
    {
       $document = Document::find($id);

       return view('admin.document.show',compact(['document']));
    }

    public function edit($id)
    {
       $document = Document::find($id);

       return view('admin.document.edit',compact(['document']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'designation' => 'required'
        ]);

        if ($request->hasFile('lien')) {
            $destinationPath = public_path('doc/chapitre/');
            $file = $request->file('lien');
            $filename = $file->getClientOriginalName();
            $lien = time().$filename;
            $file->move($destinationPath, $lien);
        } else {
            $document = Document::find($id);
            $lien = $document->lien;
        }

        Document::where('id', $id)->update([
            'designation' => $request->get('designation'),
            'lien' => $lien
        ]);

        $docChapitre = ContenirDocumentsChapitre::where('id_doc',$id)->get();

        return redirect('/document/'.$docChapitre[0]->id_chapitre)->with('success','Document modifié avec succès');
    }

    public function destroy($id)
    {
        ContenirDocumentsChapitre::where('id_doc', $id)->delete();

        Document::where('id',$id)->delete();

        return redirect()->back()->with('success','Document supprimé avec succès');
    }
}
