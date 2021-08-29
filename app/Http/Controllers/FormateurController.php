<?php

namespace App\Http\Controllers;

use App\Models\Formateur;
use App\Models\Cours;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FormateurController extends Controller
{
    public function index(){
       return view('formateur/index');
    }
    public function formateur(){
      $idUserAuth=null;
      if(Auth::user())
      $idUserAuth=Auth::user()->id;

      $users = User::select('users.*','roles.type')
      ->join('roles','users.role_id','=','roles.id')
      ->where('users.id','!=',$idUserAuth)
      ->where('users.role_id','=',4)
      ->orderBy('created_at','desc')->paginate(8);

      return view('admin.user.formateur.index',compact(['users']));
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
    public function destroyParAdmin($id)
    {
        $user = User::where('id',$id)->first();
        if($user){
        $user->delete();
        return redirect()->back()->with('success','Le formateur supprimé avec succès');
        }
        else {
            return redirect('/admins/')->with('error',"Le formateur n'existe pas ");
        }
    }
    

}
