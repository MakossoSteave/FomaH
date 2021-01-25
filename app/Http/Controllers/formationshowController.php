<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\View\View;


class formationshowController extends Controller
{
    public function index() : View
    {
        return View('stagiaire.formationShow');

    }
}