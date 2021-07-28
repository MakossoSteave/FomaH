<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Qcm;
use App\Models\Question_qcm;
use App\Models\Reponse_question_qcm;

class QcmController extends Controller
{
    public function index()
    {       
        $qcms = Qcm::with('Question_qcm.Reponse_question_qcm')->get();
        // $qcm = QCM::select('qcm.*', 'question_qcm.*', 'reponse_question_qcm.*')
        //     ->join('qcm.id', '=', 'question_qcm.qcm_id')
        //     ->join('question_qcm.id', '=', 'reponse_question_qcm.question_qcm_id')
        //     ->get();
        
        // $qcms = Qcm::get()->toArray();
        // $questions = Question_qcm::get()->toArray();
        // $reponses = Reponse_question_qcm::get()->toArray();

        // foreach($qcms as $qcm) {   
        //     $questions = Question_qcm::get()->where('qcm_id',$qcm['id'])->toArray();
        //     $qcms['qcm']['questions']  =  $questions;
        //     foreach ($questions as $question) {
        //         $reponses = Reponse_question_qcm::get()->where('question_qcm_id',$question['id'])->toArray();
        //         $qcms['qcm']['questions']['reponses'] = $reponses;
        //     }
        // }

        // return view('admin.qcm.index', compact(['qcms'], ['questions'], ['reponses']));
        return view('admin.qcm.index', compact(['qcms']));
    }

    public function create()
    {
        return view('admin.qcm.create');
    }

    public function store(Request $request)
    {
        $request->validate([]);

        do {
            $idQcm = rand(10000000, 99999999);
        } while(Qcm::find($idQcm) != null); 

        do {
            $idQuestionQcm = rand(10000000, 99999999);
        } while(Question_qcm::find($idQuestionQcm) != null);

        do {
            $idReponseQcm = rand(10000000, 99999999);
        } while(Reponse_question_qcm::find($idReponseQcm) != null);
       
        return redirect('/qcm')->with('success','QCM créé avec succès');
    }


    public function edit($id)
    {
       $qcm = Qcm::find($id);

       return view('admin.qcm.edit',compact(['qcm']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'designation' => 'required'
        ]);

        Qcm::where('id', $id)->update([]);

        return redirect('/qcm')->with('success','QCM modifié avec succes');
    }

    public function destroy($id)
    {
        QCM::where('id',$id)->delete();

        return redirect('/qcm')->with('success','QCM supprimé avec succes');
    }
}
