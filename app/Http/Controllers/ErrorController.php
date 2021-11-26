<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Categorie;
use Illuminate\Validation\Rule;

class ErrorController extends Controller
{
    public function index()
    {
        return view('error.index');
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }


    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
