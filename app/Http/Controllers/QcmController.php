<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Qcm;
use App\Models\Chapitre;
use App\Models\Question_qcm;
use App\Models\Reponse_question_qcm;

class QcmController extends Controller
{
    public function index()
    {       
        $qcms = Qcm::with('Question_qcm.Reponse_question_qcm')->get();

        return view('admin.qcm.index', compact(['qcms']));
    }

    public function create()
    {
        $chapitres = Chapitre::all();

        return view('admin.qcm.create', compact(['chapitres']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'designation' => 'required',
            'id_chapitre' => 'required'
        ]);

        do {
            $idQcm = rand(10000000, 99999999);
        } while(Qcm::find($idQcm) != null);

        Qcm::create([
            'id' => $idQcm,
            'designation' => $request->get('designation'),
            'etat' => 0,
            'id_chapitre' => $request->get('id_chapitre')
        ]);

        for ($idQuest=0; $idQuest < count($request->get('qcm')); $idQuest++) { 

            // $request->validate([
            //     "question" => 'required'
            // ]);

            do {
                $idQuestionQcm = rand(10000000, 99999999);
            } while(Question_qcm::find($idQuestionQcm) != null);
    
            Question_qcm::create([
                'id' => $idQuestionQcm,
                'question' => $request->qcm[$idQuest]['question'],
                'explication' => $request->explication[$idQuest],
                'etat' => 0,
                'qcm_id' => $idQcm
            ]);

            $count = count($request->qcm[$idQuest]);

            for ($idResp=0; $idResp < $count-1; $idResp++) { 

                // $request->validate([
                //     "reponse" => 'required',
                //     "validation" => 'required'
                // ]);
    
                do {
                    $idReponseQcm = rand(10000000, 99999999);
                } while(Reponse_question_qcm::find($idReponseQcm) != null);
        
                Reponse_question_qcm::create([
                    'id' => $idReponseQcm,
                    'reponse' => $request->qcm[$idQuest]['reponse'.$idResp],
                    'validation' => $request->validation[$idResp],
                    'etat' => 0,
                    'question_qcm_id' => $idQuestionQcm
                ]);
            }
        }
       
        return redirect('/qcm')->with('success','QCM créé avec succès');
    }


    public function edit($id)
    {
        $qcm = Qcm::with(['Question_qcm' => function($query){
            $query->where('question_qcm.qcm_id', 77360029)
            ->with(['Reponse_question_qcm' => function($subquery){
                $subquery->where('reponse_question_qcm.question_qcm_id', 35405809);
            }]);
        }])->get();

        // $qcm = Qcm::find($id);

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
