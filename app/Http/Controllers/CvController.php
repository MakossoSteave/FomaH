<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use Illuminate\Http\Request;

class CvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'designationcv' => 'required',
            'lien' => 'required'
        ]);
        
        do {
            $id = rand(10000000, 99999999);
        } while(Cv::find($id) != null);

        if ($request->hasFile('lien')) {
            $destinationPath = public_path('doc/cv/');
            $file = $request->file('lien');
            $filename = $file->getClientOriginalName();
            $lien = time().$filename;
            $file->move($destinationPath, $lien);
        } else {
            $lien = null;
        }

        Cv::create([
            'id' => $id,
            'designationcv' => $request->get('designationcv'),
            'lien' => $lien
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
