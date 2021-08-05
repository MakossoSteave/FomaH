<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// use App\Models\Formations;
// use App\Models\User;

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
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'index'])->name('register');
Route::get('/intranet', [App\Http\Controllers\IntranetController::class, 'index'])->name('intranet');
Route::get('parametre/{id}', [
    'as' => 'parametre',
    'uses' => 'App\Http\Controllers\parametreController@show'
]);

Route::get('dropdownn/{id}', [
    'as' => 'dropdownn',
    'uses' => 'App\Http\Controllers\DropdownnController@index',
]);
/*
Route::get('dropdownn/{id}{autre}', [
    'as' => 'dropdownn',
    'uses' => 'App\Http\Controllers\DropdownnController@index',
]);
*/
use App\Http\Controllers\DropdownnController;
//Route::get('dropdown/{id}',[DropdownController::class, 'index']);
Route::get('getMatiere',[DropdownnController::class, 'getMatiere'])->name('getMatiere');
Route::get('getSousMatiere',[DropdownnController::class, 'getSousMatiere'])->name('getSousMatiere');





Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/formationshow', [App\Http\Controllers\formationshowController::class, 'index'])->name('formationshow');
Route::get('message/{id}', [
    'as' => 'message',
    'uses' => 'App\Http\Controllers\messageController@index',
    'message'
]);
Route::get('/Ajoutforma', [App\Http\Controllers\FormationController::class, 'create'])->name('Ajoutforma');

Route::get('/cours', [App\Http\Controllers\CoursController::class, 'index'])->name('cours');
Route::get('/addCours', [App\Http\Controllers\CoursController::class, 'create'])->name('addCours');
Route::get('/etatCours/{id}', [App\Http\Controllers\CoursController::class, 'etat'])->name('etatCours');

Route::get('/chapitres', [App\Http\Controllers\ChapitreController::class, 'index'])->name('chapitre');
Route::get('/chapitre/{id}', [App\Http\Controllers\ChapitreController::class, 'filter'])->name('chapitre.filter');
Route::get('/addChapitre/{id}', [App\Http\Controllers\ChapitreController::class, 'create'])->name('addChapitre');

Route::get('/cursus', [App\Http\Controllers\FormationAdminController::class, 'index'])->name('cursus');
Route::get('/addFormation', [App\Http\Controllers\FormationAdminController::class, 'create'])->name('addformation');
Route::get('/createCours/{id}', [App\Http\Controllers\FormationAdminController::class, 'createCours'])->name('createCours');
Route::get('/editCours/{idCours}/{idFormation}', [App\Http\Controllers\CoursController::class, 'edit'])->name('editCours');
Route::post('/addCours/{id}', [App\Http\Controllers\FormationAdminController::class, 'addCours'])->name('addCours');
Route::get('/newCours/{id}', [App\Http\Controllers\FormationAdminController::class, 'newCours'])->name('newCours');
Route::get('/removeCoursFromFormation/{idCours}/{idFormation}', [App\Http\Controllers\FormationAdminController::class, 'removeCours'])->name('removeCours');
Route::get('/etatFormation/{id}', [App\Http\Controllers\FormationAdminController::class, 'etat'])->name('etatFormation');

Route::get('/section/{id}', [App\Http\Controllers\SectionController::class, 'index'])->name('section');
// Route::get('/addSection/{id}', [App\Http\Controllers\SectionController::class, 'create'])->name('addSection');
Route::get('/etatSection/{id}', [App\Http\Controllers\SectionController::class, 'etat'])->name('etatSection');
Route::delete('/deleteSection/{id}', [App\Http\Controllers\ChapitreController::class, 'deleteSection'])->name('deleteSection');

Route::get('/categorie', [App\Http\Controllers\CategorieController::class, 'index'])->name('categorie');
Route::get('/addCategorie', [App\Http\Controllers\CategorieController::class, 'create'])->name('addCategorie');

Route::get('/qcm', [App\Http\Controllers\QcmController::class, 'index'])->name('qcm');
Route::get('/addQcm', [App\Http\Controllers\QcmController::class, 'create'])->name('addQcm');
Route::delete('/deleteQuestion/{id}', [App\Http\Controllers\QcmController::class, 'deleteQuestion'])->name('deleteQuestion');

Route::get('/session', [App\Http\Controllers\SessionController::class, 'index'])->name('session');
Route::get('/addSession', [App\Http\Controllers\SessionController::class, 'create'])->name('addSession');
Route::get('/etatSession/{id}', [App\Http\Controllers\SessionController::class, 'etat'])->name('etatSession');

Route::resource('session','App\Http\Controllers\SessionController');
Route::resource('qcm','App\Http\Controllers\QcmController');
Route::resource('categorie','App\Http\Controllers\CategorieController');
Route::resource('section','App\Http\Controllers\SectionController');
Route::resource('cursus','App\Http\Controllers\FormationAdminController');
Route::resource('cours','App\Http\Controllers\CoursController');
Route::resource('chapitre','App\Http\Controllers\ChapitreController');
Route::resource('centre','App\Http\Controllers\FormationController');
Route::resource('stagiaire','App\Http\Controllers\StagiaireController');
Route::resource('competence','App\Http\Controllers\CompetenceController');



