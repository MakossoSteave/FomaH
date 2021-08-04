<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Formateur;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\role;
use App\Models\Stagiaire;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function index(){
        $roles = role::where('id', '!=', 1)->get();

        return view('auth.register', compact(['roles']));
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:191'],
            'surname' => ['required', 'string', 'max:191'],
            'phone' => ['required', 'regex:/[0-9]{10}/'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'=>['required','string']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    
    {
        do {
            $idUser = rand(10000000, 99999999);
        } while(User::find($idUser) != null);

       $user = User::create([
            'id' => $idUser,
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id'=>$data['role']
        ]);

        if($data['role']==3){

            do {
                $idStagiaire = rand(10000000, 99999999);
            } while(Stagiaire::find($idStagiaire) != null);

            Stagiaire::create([
                'id' =>  $idStagiaire,
                'nom' => $data['name'],
                'prenom' => $data['surname'],
                'telephone' => $data['phone'],
                'user_id' => $user->id
            ]);

        }
        else if($data['role']==4){
            do {
                $idFormateur = rand(10000000, 99999999);
            } while(Formateur::find($idFormateur) != null);

            Formateur::create([
                'id' =>  $idFormateur,
                'nom' => $data['name'],
                'prenom' => $data['surname'],
                'telephone' => $data['phone'],
                'user_id' => $user->id
            ]);
        }
        return $user;
    }
}