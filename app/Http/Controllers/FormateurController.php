<?php

namespace App\Http\Controllers;

use App\Models\Formateur;

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
}
