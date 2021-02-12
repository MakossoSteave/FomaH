<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');
Route::get('/stagiaire', [App\Http\Controllers\StagiaireController::class, 'index'])->name('stagiaire');
Route::get('/stagiaireEx', [App\Http\Controllers\StagiairesExController::class, 'index'])->name('StagiaireEx');
Route::get('/formateurEx', [App\Http\Controllers\FormateurExController::class, 'index'])->name('FormateurEx');
Route::get('/centreEx', [App\Http\Controllers\CentreExController::class, 'index'])->name('CentreEx');




Route::get('/formateur', [App\Http\Controllers\FormateurController::class, 'index'])->name('formateur');
Route::get('/centre', [App\Http\Controllers\CentreController::class, 'index'])->name('centre');
Route::get('parametre/{id}', [
    'as' => 'parametre',
    'uses' => 'App\Http\Controllers\parametreController@show',
]);
Route::get('/formationshow', [App\Http\Controllers\formationshowController::class, 'index'])->name('formationshow');
Route::get('message/{id}', [
    'as' => 'message',
    'uses' => 'App\Http\Controllers\messageController@index',
    'message'
]);
Route::get('/Ajoutforma' ,function (){
    return view('centre.Ajoutforma');
});
//Route::get('/stagiaire','StagiaireController@index')->name('stagiaire')->middleware('stagiaire');
//Route::get('/formateur','FormateurController@index')->name('formateur')->middleware('formateur');
//Route::get('/centre','CentreController@index')->name('centre')->middleware('centre');