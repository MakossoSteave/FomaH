<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Categorie;
use App\Models\Competence;
use Illuminate\Validation\Rule;
class CategorieController extends Controller
{
    public function index(Request $request)
    {
        $categories = Categorie::all();
         //dd($categories);          
        return view('admin.categorie.index',compact(['categories']));
    }

    public function create()
    {
        return view('admin.categorie.create');
    }

    public function store(Request $request)
    {
        $request->validate([
         'designation' => ['required','unique:categories','max:191']
        ]);

        do {
            $id = rand(10000000, 99999999);
        } while(Categorie::find($id) != null); 

        Categorie::create($request->all()+['id' => $id]);
       
        return redirect('/categorie')->with('success','Categorie créé avec succès');
    }


    public function edit($id)
    {
       $categorie = Categorie::find($id);

       return view('admin.categorie.edit',compact(['categorie']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'designation' => ['required','max:191', Rule::unique('categories')->where(function ($query) use($id) {
             
                return $query->where('id',"!=", $id);
            })]
        ]);

        Categorie::where('id', $id)->update(['designation' => $request->get('designation')]);

        return redirect('/categorie')->with('success','Categorie modifié avec succès');
    }

    public function destroy($id)
    {
        Categorie::where('id',$id)->delete();

        return redirect('/categorie')->with('success','Categorie supprimé avec succès');
    }
}
