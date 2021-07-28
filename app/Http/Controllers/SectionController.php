<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Section;
use Illuminate\Validation\Rule;

class SectionController extends Controller
{
    private $idChapitre;

    public function index($id)
    {
        $sections = Section::where('id_chapitre', $id)
        ->orderBy('created_at','asc')
        ->get();

        $this->idChapitre = $id;

        return view('admin.section.index',compact(['sections']), ['idChapitre' => $this->idChapitre]);
    }

    public function create($id)
    {
        $this->idChapitre = $id;

        return view('admin.section.create', ['idChapitre' => $this->idChapitre]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'designation' => ['required','max:191', Rule::unique('sections')->where(function ($query) use($request) {
             
                return $query->where('id_chapitre', $request->get('id_chapitre'));})] ,
         'contenu' => ['required','max:5000'],
         'image' => 'mimes:jpeg,png,bmp,tiff,jfif,gif,GIF |max:10000'
        ]);

        do {
            $id = rand(10000000, 99999999);
        } while(Section::find($id) != null);

        if ($request->hasFile('image')) {
            $destinationPath = public_path('img/section/');
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $image = time().$filename;
            $file->move($destinationPath, $image);
        } else {
            $image = null;
        }    

        Section::create([
            'id' => $id,
            'designation' => $request->get('designation'),
            'contenu' => $request->get('contenu'),
            'image' => $image,
            'etat' => 0,
            'id_chapitre' => $request->get('id_chapitre')
        ]);
       
        return redirect('/section/'.intval($request->get('id_chapitre')))->with('success','Section créé avec succès');
    }

    public function show($id)
    {
       $section = Section::find($id);

       return view('admin.section.show',compact(['section']));
    }

    public function edit($id)
    {
       $section = Section::find($id);

       return view('admin.section.edit',compact(['section']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'designation' => ['required','max:191', Rule::unique('sections')->where(function ($query) use($request,$id) {
             return $query->where('id_chapitre', $request->get('id_chapitre'))
                         ->where("id","!=",$id);})] ,
            'contenu' => ['required','max:5000'],
            'etat' => [
                'required',
                 Rule::in(['0', '1'])],
            'image' => 'mimes:jpeg,png,bmp,tiff,jfif,gif,GIF |max:10000'
        ]);
    
        if ($request->hasFile('image')) {
            $destinationPath = public_path('img/section/');
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $image = time().$filename;
            $file->move($destinationPath, $image);
        } else {
            $image = $request->get('image-link');
        }

        Section::where('id', $id)->update([
            'designation' => $request->get('designation'),
            'contenu' => $request->get('contenu'),
            'image' => $image,
            'etat' => $request->get('etat')
        ]);

        return redirect('/section/'.intval($request->get('id_chapitre')))->with('success','Section modifié avec succes');
    }

    public function etat($id)
    {
        $section = Section::find($id);
        $etat = !$section->etat;
        Section::where('id', $id)->update(array('etat' => $etat));
        return redirect()->back()->with('success','Etat modifié avec succes');
    }

    public function destroy($id)
    {
        Section::where('id',$id)->delete();

        return redirect()->back()->with('success','Section supprimé avec succes');
    }
}
