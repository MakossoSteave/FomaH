<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CentreController extends Controller
{
    public function index(){
       return view('centre.index');
    }
}
