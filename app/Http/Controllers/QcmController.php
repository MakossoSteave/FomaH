<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Qcm;
use App\Models\Chapitre;
use App\Models\Question_qcm;
use App\Models\Reponse_question_qcm;
use Illuminate\Validation\Rule;
class QcmController extends Controller
{
    public function index($id)
    {       
        $qcms = Qcm::where('id_chapitre', $id)->with('Question_qcm.Reponse_question_qcm')->get();

        return view('admin.qcm.index', compact(['qcms']));
    }

    public function create($id)
    {
        return view('admin.qcm.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'designation' => 'required',
            'id_chapitre' => 'required',
            'etat' => [
                'required',
                Rule::in(['0', '1'])]
            ]);

        do {
            $idQcm = rand(10000000, 99999999);
        } while(Qcm::find($idQcm) != null);

        Qcm::create([
            'id' => $idQcm,
            'designation' => $request->get('designation'),
            'etat' => $request->get('etat'),
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
                'etat' => 1,
                'qcm_id' => $idQcm
            ]);

            $count = count($request->qcm[$idQuest]);

            for ($idResp=0; $idResp < $count-5; $idResp++) { 

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
                    'validation' => $request->qcm[$idQuest]['validation'.$idResp],
                    'etat' => 1,
                    'question_qcm_id' => $idQuestionQcm
                ]);
            }
        }

        return redirect('/qcm/'.$request->get('id_chapitre'))->with('success','QCM créé avec succès');
    }


    public function edit($id)
    {
        $qcm = Qcm::where('id', $id)->with(['Question_qcm' => function($query) use($id) {
            $query->where('question_qcm.qcm_id', $id)
            ->with('Reponse_question_qcm');
        }])->get();

        $index = 0;

        $chapitres = Chapitre::all();

       return view('admin.qcm.edit',compact(['qcm'], ['chapitres'], ['index']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'designation' => 'required',
            'etat' => [
                'required',
                Rule::in(['0', '1'])]
        ]);

        Qcm::where('id', $id)->update([
            'designation' => $request->get('designation'),
            'etat' => $request->get('etat'),
            'id_chapitre' => $request->get('id_chapitre')
        ]);

        for ($idQuest=0; $idQuest < count($request->get('updateQcm')); $idQuest++) { 

            // $request->validate([
            //     "question" => 'required'
            // ]);
    
            Question_qcm::where('id', $request->updateQcm[$idQuest]['questionId'])->update([
                'question' => $request->updateQcm[$idQuest]['question'],
                'explication' => $request->updateExplication[$idQuest],
                'etat' => 1,
                'qcm_id' => $request->get('id')
            ]);

            for ($idResp=0; $idResp < 4; $idResp++) { 

                // $request->validate([
                //     "reponse" => 'required',
                //     "validation" => 'required'
                // ]);
        
                Reponse_question_qcm::where('id', $request->updateQcm[$idQuest][$idResp]['reponseId'])->update([
                    'reponse' => $request->updateQcm[$idQuest]['reponse'.$idResp],
                    'validation' => $request->updateQcm[$idQuest]['validation'.$idResp],
                    'etat' => 1,
                    'question_qcm_id' => $request->updateQcm[$idQuest]['questionId']
                ]);
            }
        }

        if($request->has('qcm')) {
            $request->validate([
                'designation' => 'required',
                'id_chapitre' => 'required'
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
                    'etat' => 1,
                    'qcm_id' => $request->get('id')
                ]);
    
                $count = count($request->qcm[$idQuest]);
    
                for ($idResp=0; $idResp < $count-5; $idResp++) { 
    
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
                        'validation' => $request->qcm[$idQuest]['validation'.$idResp],
                        'etat' => 1,
                        'question_qcm_id' => $idQuestionQcm
                    ]);
                }
            }
        }

        return redirect('/qcm/'.$request->get('id_chapitre'))->with('success','QCM modifié avec succès');
    }

    public function deleteQuestion($id)
    {
        Question_qcm::where('id',$id)->delete();
    }

    public function destroy($id)
    {
        QCM::where('id',$id)->delete();

        return redirect()->back()->with('success','QCM supprimé avec succès');
    }
}
