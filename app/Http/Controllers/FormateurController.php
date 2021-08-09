<?php

namespace App\Http\Controllers;

use App\Models\Formateur;
use App\Models\Cours;

class FormateurController extends Controller
{
    public function index(){
       return view('formateur/index');
    }
    public function findFormateurID($id)
    {
       $formateur = Formateur::where('user_id', '=', $id)->value('id');

       return $formateur;
    }
    public function destroy($id)
    {
     
      Cours::where('formateur',$id)->update([
         'formateur' => null
      ]);
      
      Formateur::where('id',$id)->delete();
    }

}
