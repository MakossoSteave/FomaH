<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InscriptionFormationcontroller extends Controller
{
 public function index(){
    return view('stagiaire/formation/register');
 }
}