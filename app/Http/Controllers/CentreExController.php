<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CentreExController extends Controller
{
    public function index(){
        return view('centreEx');
    }
}