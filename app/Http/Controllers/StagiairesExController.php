<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StagiairesExController extends Controller
{
    public function index(){
        return view('stagiaireEx');
    }
}