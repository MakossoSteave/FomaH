<?php

namespace App\Http\Controllers;

use App\Models\Formateur;
use App\Models\Cours;
use Illuminate\Support\Facades\Auth;
class FormateurController extends Controller
{
    public function index(){
       if(Auth::user())
       $id=Auth::user()->id;
      $formateur = Formateur::select('formateurs.*','users.image')
      ->join('users','users.id','formateurs.user_id')
      ->where('user_id', '=', $id)
      ->first();
       return view('formateur/index',compact(['formateur']));
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
