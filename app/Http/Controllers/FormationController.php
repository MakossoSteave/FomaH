<?php

namespace App\Http\Controllers;

use App\Models\Formations;
use Illuminate\Http\Request;

class FormationController extends Controller

{

    public function index()
    {
        $data = Formations::orderBy('id','desc')->paginate(3)->setPath('centre');
                   
        return view('centre..index',compact(['data']));
    }

    public function create()
    {
        return view('centre.Ajoutforma');
    }

    public function store(Request $request)
    {
        $request->validate([
         'libelle' => 'required',
         'description' => 'required',
         'reference' => 'required',
         'prix' => 'required',
         'userRef'=>'required'
         
        ]);

        Formations::create($request->all());
        return redirect()->back()->with('success','Create Successfully');
    }

    public function show($id)
    {
       $data =  Formations::find($id);
       return view('centre.formation.show',compact(['data']));
    }

    public function edit($id)
    {
       $data = Formations::find($id);
       return view('centre.formation.edit',compact(['data']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
         'libelle' => 'required',
         'description' => 'required',
         'prix' => 'required',
         'userRef'=>'required'
        ]);

        Formations::where('id',$id)->update($request->all());
        return redirect()->back()->with('success','Modifié avec succes');
        
    }

    public function destroy($id)
    {
        Formations::where('id',$id)->delete();
        return redirect()->back()->with('success','Supprimé avec succes');
    }

}