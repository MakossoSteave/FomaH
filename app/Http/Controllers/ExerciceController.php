<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Exercice;
use App\Models\Questions_exercice;
use App\Models\Questions_correction;

class ExerciceController extends Controller
{
    public function index($id)
    {       
        $exercices = Exercice::where('id_chapitre', $id)->with('Questions_exercice.Questions_correction')->get();

        return view('admin.exercice.index', compact(['exercices'], ['id']));
    }

    public function create($id)
    {
        return view('admin.exercice.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'enonce' => 'required'
        ]);

        do {
            $idExo = rand(10000000, 99999999);
        } while(Exercice::find($idExo) != null);

        if ($request->hasFile('image')) {
            $destinationPath = public_path('img/exercice/');
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $imageExo = time().$filename;
            $file->move($destinationPath, $imageExo);
        } else {
            $imageExo = null;
        }  

        Exercice::create([
            'id' => $idExo,
            'enonce' => $request->get('enonce'),
            'image' => $imageExo,
            'etat' => $request->get('etat'),
            'id_chapitre' => $request->get('id_chapitre')
        ]);

        for ($indexExo=0; $indexExo < count($request->get('exercice')); $indexExo++) { 

            do {
                $idQuestionExo = rand(10000000, 99999999);
            } while(Questions_exercice::find($idQuestionExo) != null);
    
            Questions_exercice::create([
                'id' => $idQuestionExo,
                'question' => $request->exercice[$indexExo]['question'],
                'etat' => 1,
                'exercice_id' => $idExo
            ]);
    
                do {
                    $idQuestionCorrection = rand(10000000, 99999999);
                } while(Questions_correction::find($idQuestionCorrection) != null);

                if ($request->hasFile("exercice.$indexExo.image")) {
                    $destinationPath = public_path('img/exercice/');
                    $file = $request->file("exercice.$indexExo.image");
                    $filename = $file->getClientOriginalName();
                    $imageCorrection = time().$filename;
                    $file->move($destinationPath, $imageCorrection);
                } else {
                    $imageCorrection = null;
                }  
        
                Questions_correction::create([
                    'id' => $idQuestionCorrection,
                    'reponse' => $request->exercice[$indexExo]['reponse'],
                    'image' => $imageCorrection,
                    'etat' => 1,
                    'question_exercice_id' => $idQuestionExo
                ]);
            }

        return redirect('/exercice/'.$request->get('id_chapitre'))->with('success','Exercice créé avec succès');
    }


    public function edit($id)
    {
        $exercices = Exercice::where('id', $id)->with(['Questions_exercice' => function($query) use($id) {
            $query->where('questions_exercices.exercice_id', $id)
            ->with('Questions_correction');
        }])->get();

       return view('admin.exercice.edit',compact(['exercices']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'enonce' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $destinationPath = public_path('img/exercice/');
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $imageUpdateExo = time().$filename;
            $file->move($destinationPath, $imageUpdateExo);
        } else {
            $exercice = Exercice::find($id);
            $imageUpdateExo = $exercice->image;
        }  

        Exercice::where('id', $id)->update([
            'enonce' => $request->get('enonce'),
            'image' => $imageUpdateExo,
            'etat' => $request->get('etat')
        ]);

        for ($indexExo=0; $indexExo < count($request->get('updateExercice')); $indexExo++) { 
    
            Questions_exercice::where('id', $request->updateExercice[$indexExo]['exerciceID'])->update([
                'question' => $request->updateExercice[$indexExo]['question'],
                'etat' => 1
            ]);

            if ($request->hasFile("exercice.$indexExo.imageUpdate")) {
                $destinationPath = public_path('img/exercice/');
                $file = $request->file("exercice.$indexExo.imageUpdate");
                $filename = $file->getClientOriginalName();
                $imageUpdateExo = time().$filename;
                $file->move($destinationPath, $imageUpdateExo);
            } else {
                $correction = Questions_correction::find($request->updateExercice[$indexExo]['correctionID']);
                $imageUpdateExo = $correction->image;
            }  
        
            Questions_correction::where('id', $request->updateExercice[$indexExo]['correctionID'])->update([
                'reponse' => $request->updateExercice[$indexExo]['reponse'],
                'image' => $imageUpdateExo,
                'etat' => 1
            ]);
        }

        if($request->has('exercice')) {
    
            for ($indexExo=0; $indexExo < count($request->get('exercice')); $indexExo++) { 
    
                do {
                    $idQuestionExo = rand(10000000, 99999999);
                } while(Questions_exercice::find($idQuestionExo) != null);
        
                Questions_exercice::create([
                    'id' => $idQuestionExo,
                    'question' => $request->exercice[$indexExo]['question'],
                    'etat' => 1,
                    'exercice_id' => $id
                ]);
        
                    do {
                        $idQuestionCorrection = rand(10000000, 99999999);
                    } while(Questions_correction::find($idQuestionCorrection) != null);
    
                    if ($request->hasFile("exercice.$indexExo.image")) {
                        $destinationPath = public_path('img/exercice/');
                        $file = $request->file("exercice.$indexExo.image");
                        $filename = $file->getClientOriginalName();
                        $imageCorrection = time().$filename;
                        $file->move($destinationPath, $imageCorrection);
                    } else {
                        $imageCorrection = null;
                    }  
            
                    Questions_correction::create([
                        'id' => $idQuestionCorrection,
                        'reponse' => $request->exercice[$indexExo]['reponse'],
                        'image' => $imageCorrection,
                        'etat' => 1,
                        'question_exercice_id' => $idQuestionExo
                    ]);
                }
            }

        return redirect('/exercice/'.$request->get('id_chapitre'))->with('success','Exercice modifié avec succès');
    }

    public function deleteQuestionExercice($id)
    {
        Questions_exercice::where('id',$id)->delete();
    }

    public function destroy($id)
    {
        Exercice::where('id',$id)->delete();

        return redirect()->back()->with('success','Exercice supprimé avec succès');
    }

    public function etat($id)
    {
        $exercice = Exercice::find($id);
        $etat = !$exercice->etat;

        Exercice::where('id', $id)->update(array('etat' => $etat));
        return redirect()->back()->with('success','Etat modifié avec succès');
    }
}
