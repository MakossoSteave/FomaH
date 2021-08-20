<?php

namespace App\Http\Controllers;

use App\Models\Centre;
use App\Models\Formation;
use App\Models\Stagiaire;
use App\Models\User;
use App\Models\Organisation;
use App\Models\Formateur;
use App\Models\types_inscription;
use App\Models\Suivre_formation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\FilenameImage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class StagiaireController extends Controller
{
    
    public function index(){
        $data = Formation::orderBy('id','desc')->paginate(8)->setPath('stagiaire');
        $idUserAuth=null;

        if(Auth::user())
        $idUserAuth=Auth::user()->id;
        $stagiaire = Stagiaire::select('stagiaires.*')->where('user_id', $idUserAuth)->first();
        if($stagiaire){
            $SuivreFormation = Suivre_formation::select('suivre_formations.*')
            ->join('sessions','sessions.id','suivre_formations.id_session')
            ->join('lier_sessions_stagiaires','lier_sessions_stagiaires.id_stagiaire','suivre_formations.id_stagiaire')
            ->where('suivre_formations.id_stagiaire', $stagiaire->id)
            ->where('lier_sessions_stagiaires.etat',1)
            ->where('sessions.etat',1)
            ->where('sessions.statut_id',3)->exists();}
        else {
            $SuivreFormation = false; 
        }
        return view('stagiaire/index',compact(['data']),['SuivreFormation'=>$SuivreFormation]);
    }

    public function create(Request $request)
    {
        $typeInscriptions = types_inscription::all();
        
        $organisations = Organisation::orderBy('designation','asc')->get();
        $request->session()->put('organisations', $organisations);
        $formateurs = Formateur::orderBy('nom','asc')->get();
        $request->session()->put('formateurs', $formateurs);
        
        $centres = Centre::orderBy('designation','asc')->get();
        $request->session()->put('centres', $centres);
        return view('admin.user.stagiaire.create', compact(['typeInscriptions','organisations','centres','formateurs']));
    }

    public function show($id)
    {
       // $formation  = Formation::find($ids);
        $Formation = Formation ::find($id);
        $user = $Formation->userRef;
        $al = User:: find($user);
        $referenceee = Formation::where("userRef",$user)->take(10)->get();
        
      
        //$databis =Formation::all();

       return view('stagiaire.formation.Show',compact(['Formation','al', 'referenceee']));
    }
    

    public function stagiaire(){
        $stagiaires = Stagiaire::select('stagiaires.*','users.image','users.email','formateurs.nom as coachNom','formateurs.prenom as coachPrenom','organisations.designation as organisation','centres.designation as centre','types_inscriptions.type as typeInscription')
        ->join('types_inscriptions','stagiaires.type_inscription_id','=','types_inscriptions.id')
        ->leftJoin('organisations','stagiaires.organisation_id','=','organisations.id')
        ->leftJoin('centres','stagiaires.centre_id','=','centres.id')
        ->leftJoin('formateurs','stagiaires.formateur_id','=','formateurs.id')
        ->join('users','stagiaires.user_id','=','users.id')
        ->orderBy('stagiaires.created_at','desc')
        ->paginate(5)->setPath('stagiaires');
        return view('admin.user.stagiaire.index',compact('stagiaires'));
    }

    public function edit(Request $request,$id){

      $stagiaire =Stagiaire::select('stagiaires.*','users.image','users.email','formateurs.nom as coachNom','formateurs.prenom as coachPrenom','organisations.designation as organisation','types_inscriptions.type as typeInscription')
      ->join('types_inscriptions','stagiaires.type_inscription_id','=','types_inscriptions.id')
      ->leftJoin('organisations','stagiaires.organisation_id','=','organisations.id')
      ->leftJoin('formateurs','stagiaires.formateur_id','=','formateurs.id')
      ->join('users','stagiaires.user_id','=','users.id')
      ->where("stagiaires.user_id",$id)
      ->first();
      if($stagiaire){
        $typeInscriptions = types_inscription::all();
        $request->session()->put('typeInscriptions', $typeInscriptions);
        $organisations = Organisation::orderBy('designation','asc')->get();
        $request->session()->put('organisations', $organisations);
    
        $formateurs = Formateur::orderBy('nom','asc')->get();
        $request->session()->put('formateurs', $formateurs);
        
        $centres = Centre::orderBy('designation','asc')->get();
        $request->session()->put('centres', $centres);  
    
        return view('admin.user.stagiaire.edit',compact(['stagiaire','typeInscriptions','organisations','centres','formateurs']));
      }
      else {
        return redirect('/stagiaires/')->with('error',"Le stagiaire n'existe pas ");
       }
   
    }
    public function store(Request $request){

            $request->validate([
                'email' => ['required','email','max:191', 'unique:users'],
                'nom' => ['required','string','max:191'],
                'prenom' => ['nullable','string','max:191'],
                'telephone' => ['nullable','regex:/[0-9]{9}/','max:10'],
                'formateur_id' => ['nullable','numeric'
                ,'in:'.$request->session()->get('formateurs')->implode('id', ', ')
                ],
                'centre_id' => ['nullable','numeric'
                ,'in:'.$request->session()->get('centres')->implode('id', ', ')],
                'typeInscription' => ['required','numeric',
                'in:'.$request->session()->get('typeInscriptions')->implode('id', ', ')],
                'organisation_id' => ['nullable','numeric'
                ,'in:'.$request->session()->get('organisations')->implode('id', ', ')],
                'motdepasse' => ['required','string', 'min:8', 'confirmed'],
                'motdepasse_confirmation' => ['required','string', 'min:8'], 
                'image' => ['mimes:jpeg,png,bmp,tif,gif,ico,jpg,GIF','max:10000',
                        new FilenameImage('/[\w\W]{4,181}$/')]
            ]);
            if( (($request->get('typeInscription')==2) && (!empty($request->get('centre_id')))) || (($request->get('typeInscription')==3) && (!empty($request->get('organisation_id')))) ){
                return redirect('/addStagiaire/')->with('error',"Vous devez choisir soit un centre soit une organisation !");
            }
            if(($request->get('typeInscription')==1) && (!empty($request->get('organisation_id')) || !empty($request->get('centre_id')) )){
                return redirect('/addStagiaire/')->with('error',"Pas d'organisation ou de centre pour un stagiaire indépendant !");
            }
            if(($request->get('typeInscription')==2) && ( empty($request->get('organisation_id')) )){
                return redirect('/addStagiaire/')->with('error',"Vous devez choisir une organisation !");
            }
            if(($request->get('typeInscription')==3) && (empty($request->get('centre_id')) )){
                return redirect('/addStagiaire/')->with('error',"Vous devez choisir un centre !");
            }
            

            do {
                $id = rand(10000000, 99999999);
            } while(User::find($id) != null);
   
            if ($request->hasFile('image')) {
                $destinationPath = public_path('img/user/');
                $file = $request->file('image');
                $filename = $file->getClientOriginalName();
                $image = time().$filename;
                $file->move($destinationPath, $image);
        } else {
            $image = null;
        }
            if (!empty($request->get('prenom'))) {
                $prenom = $request->get('prenom');
            } else {
                $prenom = null;
            }

            if (!empty($request->get('formateur_id'))) {
                $coach = $request->get('formateur_id');
                } else {
                    $coach = null;
                }
            if (!empty($request->get('telephone'))) {
                $telephone = $request->get('telephone');
                } else {
                    $telephone = null;
                }
            if (!empty($request->get('centre_id'))) {
            $centre = $request->get('centre_id');
            } else {
            $centre = null;
            }
            if (!empty($request->get('organisation_id'))) {
            $organisation = $request->get('organisation_id');
            } else {
            $organisation = null;
            }
            User::create([
            'id' => $id,
            'name' => $request->get('nom'),
            'email' =>$request->get('email'),
            'password' => Hash::make($request->get('motdepasse')),
            'image' => $image,
            'role_id'=>3
            ]);
            do {
                $idStagiaire = rand(10000000, 99999999);
            } while(Stagiaire::find($idStagiaire) != null);
            Stagiaire::create([
                'id' =>  $idStagiaire,
                'nom' =>  $request->get('nom'),
                'prenom' => $prenom,
                'telephone' => $telephone,
                'formateur_id' =>  $coach,
                'user_id' =>$id,
                'type_inscription_id'=>$request->get('typeInscription'),
                'centre_id' => $centre,
                'organisation_id' => $organisation
            ]);

           return redirect('/stagiaires/')->with('success','Le stagiaire a été ajouté avec succès');
          
    }
    
       public function update(Request $request,$idUser){
          
        $stagiaire = Stagiaire::where('user_id',$idUser)->first();
        $user = User::find($idUser);
        if($stagiaire)
        {
                if(!empty($request->get('motdepasse'))){
                    $request->validate([
                        'motdepasse' => ['string', 'min:8', 'confirmed'],
                        'Oldmotdepasse'  =>['required','string', 'min:8'],
                        'motdepasse_confirmation' => ['required','string', 'min:8']]);
                        $oldMdp=$request->get('Oldmotdepasse');
                        $oldMdpBD=(User::find($idUser))->password;
                        if(! Hash::check($oldMdp,$oldMdpBD)){ 
                            return redirect()->back()->with('error','Mot de passe incorrecte !'); 
                            }
                        }
                $request->validate([
                    'email' => ['required','email','max:191',Rule::unique('users')->where(function ($query) use($idUser) {
             
                        return $query->where('id',"!=", $idUser);
                    })],
                    'nom' => ['required','string','max:191'],
                    'prenom' => ['nullable','string','max:191'],
                    'telephone' => ['nullable','regex:/[0-9]{9}/','max:10'],
                    'formateur_id' => ['nullable','numeric'
                    ,'in:'.$request->session()->get('formateurs')->implode('id', ', ')
                    ],
                    'centre_id' => ['nullable','numeric'
                    ,'in:'.$request->session()->get('centres')->implode('id', ', ')],
                    'typeInscription' => ['required','numeric',
                    'in:'.$request->session()->get('typeInscriptions')->implode('id', ', ')],
                    'organisation_id' => ['nullable','numeric'
                    ,'in:'.$request->session()->get('organisations')->implode('id', ', ')],
                    'image' => ['mimes:jpeg,png,bmp,tif,gif,ico,jpg,GIF','max:10000',
                            new FilenameImage('/[\w\W]{4,181}$/')]
                ]);
                if( (($request->get('typeInscription')==2) && (!empty($request->get('centre_id')))) || (($request->get('typeInscription')==3) && (!empty($request->get('organisation_id')))) ){
                    return redirect()->back()->with('error',"Vous devez choisir soit un centre soit une organisation !");
                }
                if( ($request->get('typeInscription')==1) && ( (!empty($request->get('organisation_id')) && ($stagiaire->organisation_id==null)) || (!empty($request->get('centre_id'))) && ($stagiaire->centre_id==null) )){
                    return redirect()->back()->with('error',"Pas d'organisation ou de centre pour un stagiaire indépendant !");
                }
                if(($request->get('typeInscription')==2) && (empty($request->get('organisation_id')) )){
                    return redirect()->back()->with('error',"Vous devez choisir une organisation !");
                }
                if(($request->get('typeInscription')==3) && (empty($request->get('centre_id')) )){
                    return redirect()->back()->with('error',"Vous devez choisir un centre !");
                }
                
                if ($request->hasFile('image')) {
                    $destinationPath = public_path('img/user/');
                    $file = $request->file('image');
                    $filename = $file->getClientOriginalName();
                    $image = time().$filename;
                    $file->move($destinationPath, $image);
                } else {
                    $image = $user->image;
                }
                if (!empty($request->get('prenom'))) {
                    $prenom = $request->get('prenom');
                } else {
                    $prenom = null;
                }

                if (!empty($request->get('formateur_id'))) {
                    $coach = $request->get('formateur_id');
                    } else {
                        $coach = null;
                    }
                if (!empty($request->get('telephone'))) {
                    $telephone = $request->get('telephone');
                    } else {
                        $telephone = null;
                    }

                if($request->get('typeInscription') == $stagiaire->type_inscription_id){
                    $centre = $stagiaire->centre_id;
                    $organisation = $stagiaire->organisation_id;
                }
                else if($request->get('typeInscription')== 1){
                    $centre = null;
                    $organisation = null;
                }
                else {
                    if (!empty($request->get('centre_id'))) {
                    $centre = $request->get('centre_id');
                    } else {
                    $centre = null;
                    }
                    if (!empty($request->get('organisation_id'))) {
                    $organisation = $request->get('organisation_id');
                    } else {
                    $organisation = null;
                    }
                }
                if($request->get('motdepasse'))
                {
                    User::where('id',$idUser)->update([
                    'name' => $request->get('nom'),
                    'email' =>$request->get('email'),
                    'password' => Hash::make($request->get('motdepasse')),
                    'image' => $image,
                    'role_id'=>3
                    ]);
                }
                else {
                    User::where('id',$idUser)->update([
                        'name' => $request->get('nom'),
                        'email' =>$request->get('email'), 
                        'image' => $image,
                        'role_id'=>3
                    ]);
                    }
            
                Stagiaire::where('user_id',$idUser)->update([
                
                    'nom' =>  $request->get('nom'),
                    'prenom' => $prenom,
                    'telephone' => $telephone,
                    'formateur_id' =>  $coach,
                    'type_inscription_id'=>$request->get('typeInscription'),
                    'centre_id' => $centre,
                    'organisation_id' => $organisation
                ]);

            return redirect('/stagiaires/')->with('success','Le stagiaire a été modifié avec succès');
      
        } else {
            return redirect('/stagiaires/')->with('error',"Le stagiaire n'existe pas ");
        }
}
    public function destroy($id)
    {
        $stagiaire = Stagiaire::where('id',$id)->first();
        if($stagiaire){
        $stagiaire->delete();
        User::where('id',$stagiaire->user_id)->delete();
        return redirect()->back()->with('success','Stagiaire supprimé avec succès');
    }
    else {
      return redirect('/stagiaires/')->with('error',"Le stagiaire n'existe pas ");
     }
    }
}