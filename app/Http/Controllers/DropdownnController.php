<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class DropdownnController extends Controller
{
 public function index()
 {
 $categories = DB::table("categories")->pluck("designation","id");
 return view('dropdownn',compact('categories'));
 }
 // traduction de pluck--> cueillir
 public function getMatiere(Request $request)
 {
 $matieres = DB::table("matieres")
 ->where("categorie_id",$request->categorie_id)
 ->pluck("designation_matiere","id");

 return response()->json($matieres);
 }
 
 public function getSousMatiere(Request $request)
 {
 $sous_matieres = DB::table("sous_matieres")
 ->where("matiere_id",$request->matiere_id)
 ->pluck("designation_sous_matiere","id");
 return response()->json($sous_matieres);
 }
 
}