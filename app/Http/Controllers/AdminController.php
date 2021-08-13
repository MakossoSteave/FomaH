<?php

namespace App\Http\Controllers;
use App\Models\Centre;
use App\Models\role;
use App\Models\User;
use App\Models\Formateur;
use App\Models\Organisation;
use App\Models\Stagiaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Rules\FilenameImage;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
   public function index(){
     //  return view('admin.index');
     return redirect('/session');
    }
    public function admin(){
        $idUserAuth=null;
        if(Auth::user())
        $idUserAuth=Auth::user()->id;

        $users = User::select('users.*','roles.type')
        ->join('roles','users.role_id','=','roles.id')
        ->where('users.id','!=',$idUserAuth)
        ->where('users.role_id','=',1)
        ->orderBy('created_at','desc')->paginate(8)->setPath('admins');

        return view('admin.user.admin.index',compact(['users']));
    }
    public function create(Request $request)
    {
        return view('admin.user.admin.create');
    }
    public function edit(Request $request,$id){

        $user = User::select('users.*','roles.type')
        ->join('roles','users.role_id','=','roles.id')
        ->where('users.id','=',$id)
        ->first();
        if($user){
            $roles = role::where('id',"=",1)
            ->orWhere('id',"=",4)->get();
            $request->session()->put('roles', $roles);
            return view('admin.user.admin.edit',compact(['user','roles']));
        }
        else {
          return redirect('/admins/')->with('error',"L'administrateur n'existe pas ");
         }
     
      }
      public function store(Request $request){
        
                $request->validate([
                    'email' => ['required','email','max:191','unique:users'],
                    'nom' => ['required','string','max:191'],
                    'motdepasse' => ['string', 'min:8', 'confirmed'],
                    'motdepasse_confirmation' => ['required','string', 'min:8'],
                    'image' => ['mimes:jpeg,png,bmp,tif,gif,ico,GIF,jpg','max:10000',
                            new FilenameImage('/[\w\W]{4,181}$/')]
                ]);
              
                
                if ($request->hasFile('image')) {
                    $destinationPath = public_path('img/user/');
                    $file = $request->file('image');
                    $filename = $file->getClientOriginalName();
                    $image = time().$filename;
                    $file->move($destinationPath, $image);
                } else {
                    $image = null;
                }
               
                do {
                    $idUser = rand(10000000, 99999999);
                } while(User::find($idUser) != null);

                User::create([
                'id' => $idUser,
                'name' => $request->get('nom'),
                'email' =>$request->get('email'),
                'password' => Hash::make($request->get('motdepasse')),
                'image' => $image,
                'role_id'=>1
                ]);
                do {
                    $idFormateur = rand(10000000, 99999999);
                } while(Formateur::find($idFormateur) != null);
                Formateur::create([
                    'id' => $idFormateur,
                    'nom' => $request->get('nom'),
                    'user_id' =>$idUser
                    ]);
                    
            

            return redirect('/admins/')->with('success',"L'administrateur a été ajouté avec succès");
      
        } 
      
      public function update(Request $request,$id){
        $user = User::find($id);
        if($user)
        {
                if(!empty($request->get('motdepasse'))){
                    $request->validate([
                    'motdepasse' => ['string', 'min:8', 'confirmed'],
                    'Oldmotdepasse'  =>['required','string', 'min:8'],
                    'motdepasse_confirmation' => ['required','string', 'min:8']]);
                    $oldMdp=$request->get('Oldmotdepasse');
                    $oldMdpBD=(User::find($id))->password;
                    if(! Hash::check($oldMdp,$oldMdpBD)){ 
                        return redirect()->back()->with('error','Mot de passe incorrecte !'); 
                        }
                    }
                $request->validate([
                    'email' => ['required','email','max:191',Rule::unique('users')->where(function ($query) use($id) {
             
                        return $query->where('id',"!=", $id);
                    })],
                    'nom' => ['required','string','max:191'],
                    'role' => ['required','numeric',
                    'in:'.$request->session()->get('roles')->implode('id', ', ')],
                    'image' => ['mimes:jpeg,png,bmp,tif,gif,ico,GIF,jpg','max:10000',
                            new FilenameImage('/[\w\W]{4,181}$/')]
                ]);
              
                
                if ($request->hasFile('image')) {
                    $destinationPath = public_path('img/user/');
                    $file = $request->file('image');
                    $filename = $file->getClientOriginalName();
                    $image = time().$filename;
                    $file->move($destinationPath, $image);
                } else {
                    $image = $user->image;
                }
               
                if($request->get('motdepasse'))
                {
                    User::where('id',$id)->update([
                    'name' => $request->get('nom'),
                    'email' =>$request->get('email'),
                    'password' => Hash::make($request->get('motdepasse')),
                    'image' => $image,
                    'role_id'=>$request->get('role')
                    ]);
                }
                else {
                    User::where('id',$id)->update([
                        'name' => $request->get('nom'),
                        'email' =>$request->get('email'), 
                        'image' => $image,
                        'role_id'=>$request->get('role')
                    ]);
                    }

          /* if($user->role_id !=$request->get('role') ) {
                if($request->get('role')==1){
                    do {
                        $idFormateur = rand(10000000, 99999999);
                    } while(Formateur::find($idFormateur) != null);
        
                    Formateur::create([
                        'id' =>  $idFormateur,
                        'nom' => $request->get('nom'),
                        'user_id' => $id
                    ]);
                }/* else if($request->get('role')==4){
                    Formateur::where('user_id',$id)->delete();
                }*/ /*else if($request->get('role')==2){
                    Stagiaire::where('user_id',$id)->delete();
                    do {
                        $idCentre = rand(10000000, 99999999);
                    } while(Centre::find($idCentre) != null);
                    Centre::create([
                        'id' =>  $idCentre,
                        'designation' => $request->get('nom'),
                        'user_id' => $id
                    ]);
                }
                else if($request->get('role')==5){
                    do {
                        $idOrganisation = rand(10000000, 99999999);
                    } while(Organisation::find($idOrganisation) != null);
                    Organisation::create([
                        'id' =>  $idOrganisation,
                        'designation' => $request->get('nom'),
                        'user_id' => $id
                    ]);
                }*/
            /*}*/
            

            return redirect('/admins/')->with('success',"L'administrateur a été modifié avec succès");
      
        } else {
            return redirect('/admins/')->with('error',"L'administrateur n'existe pas ");
        }
      }
    
      public function destroy($id)
    {
        $user = User::where('id',$id)->first();
        if($user){
        $user->delete();
        return redirect()->back()->with('success','Administrateur supprimé avec succès');
        }
        else {
            return redirect('/admins/')->with('error',"L'administrateur n'existe pas ");
        }
    }
}
