<?php

namespace App\Http\Controllers;

use App\Models\Centre;
use App\Models\Formation;
use App\Models\Stagiaire;
use App\Models\User;
use App\Models\Organisation;
use App\Models\Formateur;
use App\Models\types_inscription;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\FilenameImage;
use Illuminate\Support\Facades\Hash;
class StagiaireController extends Controller
{
    public function index(){
        $data = Formation::orderBy('id','desc')->paginate(8)->setPath('stagiaire');

        return view('stagiaire/index',compact(['data']));
    }

    public function create()
    {
        $typeInscriptions = types_inscription::all();

        $organisations = Organisation::orderBy('designation','asc')->get();

        $formateurs = Formateur::orderBy('nom','asc')->get();

        $centres = Centre::orderBy('designation','asc')->get();
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
        $stagiaires = Stagiaire::select('stagiaires.*','users.image','users.email','formateurs.nom as coachNom','formateurs.prenom as coachPrenom','organisations.designation as organisation','types_inscriptions.type as typeInscription')
        ->join('types_inscriptions','stagiaires.type_inscription_id','=','types_inscriptions.id')
        ->leftJoin('organisations','stagiaires.organisation_id','=','organisations.id')
        ->leftJoin('formateurs','stagiaires.formateur_id','=','formateurs.id')
        ->join('users','stagiaires.user_id','=','users.id')
        ->orderBy('stagiaires.created_at','desc')
        ->paginate(5)->setPath('stagiaires');
        return view('admin.user.stagiaire.index',compact('stagiaires'));
    }

    public function edit($id){
      
    $stagiaire =Stagiaire::select('stagiaires.*','users.image','users.email','formateurs.nom as coachNom','formateurs.prenom as coachPrenom','organisations.designation as organisation','types_inscriptions.type as typeInscription')
      ->join('types_inscriptions','stagiaires.type_inscription_id','=','types_inscriptions.id')
      ->leftJoin('organisations','stagiaires.organisation_id','=','organisations.id')
      ->leftJoin('formateurs','stagiaires.formateur_id','=','formateurs.id')
      ->join('users','stagiaires.user_id','=','users.id')
      ->where("stagiaires.id",$id)
      ->first();
    return view('admin.user.stagiaire.edit',compact(['stagiaire']));
    }
    public function store(Request $request){
        $request->validate([
            'email' => ['required','email','max:191', 'unique:users'],
            'nom' => ['required','string','max:191'],
            'prenom' => ['nullable','string','max:191'],
            'telephone' => ['nullable','regex:/[0-9]{10}/'],
            'formateur_id' => ['nullable','numeric'],
            'centre_id' => ['nullable','numeric'],
            'typeInscription'=> ['required','numeric'],
            'organisation_id' => ['nullable','numeric'],
            'motdepasse' => ['string', 'min:8', 'confirmed'],
            'motdepasse_confirmation' => ['required','string', 'min:8'], 
            'image' => ['mimes:jpeg,png,bmp,tif,gif,ico,GIF','max:10000',
                    new FilenameImage('/[\w\W]{4,181}$/')]
           ]);
   
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

           if (!empty($request->get('formation_id'))) {
            $coach = $request->get('formation_id');
            } else {
                $coach = null;
            }
            if (!empty($request->get('telephone'))) {
                $telephone = $request->get('telephone');
                } else {
                    $telephone = null;
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
                'type_inscription_id'=>$request->get('typeInscription')
            ]);

           return redirect('/stagiaires/')->with('success','Le stagiaire a été ajouté avec succès');
          
       }
    public function destroy($id)
    {
        $stagiaire = Stagiaire::where('id',$id)->first();
        $stagiaire->delete();
        User::where('id',$stagiaire->user_id)->delete();
        return redirect()->back()->with('success','Stagiaire supprimé avec succès');
    }
}