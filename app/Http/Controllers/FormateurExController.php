<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormateurExController extends Controller
{
    public function index(){
        return view('formateurEx');
    }
}