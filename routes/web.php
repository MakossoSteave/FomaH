<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Formations;
use App\Models\User;

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
Route::get('/stagiaire/{id}{ref} ', [App\Http\Controllers\StagiaireController::class, 'index'])->name('stagiaire');
Route::get('/organisme', [App\Http\Controllers\OrganismeController::class, 'index'])->name('organisme');
Route::get('/inscriptionformation', [App\Http\Controllers\InscriptionFormationcontroller::class, 'index'])->name('inscription');
Route::get('/stagiaireEx', [App\Http\Controllers\StagiairesExController::class, 'index'])->name('StagiaireEx');
Route::get('/formateurEx', [App\Http\Controllers\FormateurExController::class, 'index'])->name('FormateurEx');
Route::get('/centreEx', [App\Http\Controllers\CentreExController::class, 'index'])->name('CentreEx');
Route::get('/formateur', [App\Http\Controllers\FormateurController::class, 'index'])->name('formateur');
Route::get('/centre', [App\Http\Controllers\CentreController::class, 'index'])->name('centre');
Route::get('/intranet', [App\Http\Controllers\IntranetController::class, 'index'])->name('intranet');
Route::get('parametre/{id}', [
    'as' => 'parametre',
    'uses' => 'App\Http\Controllers\parametreController@show',
]);
Route::get('/cours',[App\Http\Controllers\CoursController::class, 'index'])->name('cours');
Route::get('/lives',[App\Http\Controllers\LiveController::class, 'index'])->name('live');

Route::get('/formationshow', [App\Http\Controllers\formationshowController::class, 'index'])->name('formationshow');
Route::get('message/{id}', [
    'as' => 'message',
    'uses' => 'App\Http\Controllers\messageController@index',
    'message'
]);
Route::get('Ajoutforma', function () {
    return view('centre.Ajoutforma');
});
Route::resource('centre','App\Http\Controllers\FormationController');
Route::resource('stagiaire','App\Http\Controllers\StagiaireController');