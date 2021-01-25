<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\View\View;
use App\Models\User;


class messageController extends Controller
{
    public function __construct()
    {
        $this->middleware('message');

    }
    public function index(user $id) : View
    {
        
            return View('stagiaire.message',compact('id'));

    }
}