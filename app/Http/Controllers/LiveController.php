<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LiveController extends Controller
{
    public function index(){
        return view('stagiaire.intranet.live.index');
    }
}