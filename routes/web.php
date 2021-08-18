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
Route::get('/admin', /*[App\Http\Controllers\AdminController::class, 'index']*/
  function () {
    return redirect('/session');
})->name('admin');
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

Route::get('/competence', [App\Http\Controllers\CompetenceController::class, 'index'])->name('listeCompetence');
Route::get('parametre/{id}', [
    'as' => 'parametre',
    'uses' => 'App\Http\Controllers\parametreController@show'
]);


Route::get('dropdownn/{id}',[App\Http\Controllers\DropdownnController::class, 'index'])->name('dropdownn');
Route::get('getMatiere',[App\Http\Controllers\DropdownnController::class, 'getMatiere'])->name('getMatiere');
Route::get('getSousMatiere',[App\Http\Controllers\DropdownnController::class, 'getSousMatiere'])->name('getSousMatiere');


Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/formationshow', [App\Http\Controllers\formationshowController::class, 'index'])->name('formationshow');
Route::get('message/{id}', [
    'as' => 'message',
    'uses' => 'App\Http\Controllers\messageController@index',
    'message'
]);
Route::get('/Ajoutforma', [App\Http\Controllers\FormationController::class, 'create'])->name('Ajoutforma');

Route::get('/cours', [App\Http\Controllers\CoursController::class, 'index'])->name('cours');
Route::get('/cours/{id}', [App\Http\Controllers\CoursController::class, 'filter'])->name('coursFilter');
Route::get('/addCours', [App\Http\Controllers\CoursController::class, 'create'])->name('addCours');
Route::get('/etatCours/{id}', [App\Http\Controllers\CoursController::class, 'etat'])->name('etatCours');

Route::get('/chapitres/{id}', [App\Http\Controllers\ChapitreController::class, 'index'])->name('chapitres');
Route::get('/addChapitre/{id}', [App\Http\Controllers\ChapitreController::class, 'create'])->name('addChapitre');

Route::get('/cursus', [App\Http\Controllers\FormationAdminController::class, 'index'])->name('cursus');
Route::get('/addFormation', [App\Http\Controllers\FormationAdminController::class, 'create'])->name('addformation');
Route::get('/createCours/{id}', [App\Http\Controllers\FormationAdminController::class, 'createCours'])->name('createCours');
Route::get('/editCours/{idCours}/{idFormation}', [App\Http\Controllers\CoursController::class, 'editFilter'])->name('editCours');
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

Route::get('/qcm/{id}', [App\Http\Controllers\QcmController::class, 'index'])->name('qcmChapitre');
Route::get('/addQcm/{id}', [App\Http\Controllers\QcmController::class, 'create'])->name('addQcm');
Route::delete('/deleteQuestion/{id}', [App\Http\Controllers\QcmController::class, 'deleteQuestion'])->name('deleteQuestion');
Route::get('/etatQCM/{id}', [App\Http\Controllers\QcmController::class, 'etat'])->name('etatQCM');

Route::get('/session', [App\Http\Controllers\SessionController::class, 'index'])->name('session');
Route::get('/addSession', [App\Http\Controllers\SessionController::class, 'create'])->name('addSession');
Route::get('/etatSession/{id}', [App\Http\Controllers\SessionController::class, 'etat'])->name('etatSession');
Route::get('/StagiaireSession/{id}', [App\Http\Controllers\SessionController::class, 'Session_Stagiaire'])->name('StagiaireSession');
Route::get('/AjouterStagiaireSession/{id}', [App\Http\Controllers\SessionController::class, 'Session_Stagiaire_Ajout'])->name('AddStagiaireSession');
Route::post('/AddStagiaire/{id}', [App\Http\Controllers\SessionController::class, 'store_stagiaire_session'])->name('AddStagiaire');
Route::delete('/removeStagiaire/{id}/{idSession}', [App\Http\Controllers\SessionController::class, 'removeStagiaire'])->name('removeStagiaire');
Route::get('/etatStagiaireSession/{id}/{idSession}', [App\Http\Controllers\SessionController::class, 'etatStagiaireSession'])->name('etatStagiaireSession');
Route::get('/editStagiaireSession/{id}/{idSession}', [App\Http\Controllers\SessionController::class, 'editStagiaire'])->name('editStagiaireSession');
Route::get('/createPDF/{id}/{idSession}', [App\Http\Controllers\SessionController::class, 'createPDF'])->name('createPDF');
Route::post('/editStagiaireSession/{id}/{idSession}', [App\Http\Controllers\SessionController::class, 'editResultStagiaire'])->name('editResultStagiaire');
Route::get('/progressionStagiaire/{id}/{idSession}', [App\Http\Controllers\SessionController::class, 'progressionStagiaire'])->name('progressionStagiaire');

Route::get('/document/{id}', [App\Http\Controllers\DocumentController::class, 'index'])->name('document');
Route::get('/addDocument/{id}', [App\Http\Controllers\DocumentController::class, 'create'])->name('addDocument');

Route::get('/projet/{id}', [App\Http\Controllers\ProjetController::class, 'index'])->name('projet');
Route::get('/addProjet/{id}', [App\Http\Controllers\ProjetController::class, 'create'])->name('addProjet');
Route::get('/etatProjet/{id}', [App\Http\Controllers\ProjetController::class, 'etat'])->name('etatProjet');
Route::delete('/deleteDocument/{id}', [App\Http\Controllers\ProjetController::class, 'deleteDocument'])->name('deleteDocument');

Route::get('/exercice/{id}', [App\Http\Controllers\ExerciceController::class, 'index'])->name('exercice');
Route::get('/addExercice/{id}', [App\Http\Controllers\ExerciceController::class, 'create'])->name('addExercice');
Route::get('/etatExercice/{id}', [App\Http\Controllers\ExerciceController::class, 'etat'])->name('etatExercice');
Route::delete('/deleteQuestionExercice/{id}', [App\Http\Controllers\ExerciceController::class, 'deleteQuestionExercice'])->name('deleteQuestionExercice');

Route::get('/stagiaires', [App\Http\Controllers\StagiaireController::class, 'stagiaire'])->name('stagiaires');
Route::get('/addStagiaire', [App\Http\Controllers\StagiaireController::class, 'create'])->name('addStagiaire');

Route::get('/utilisateurs', [App\Http\Controllers\UtilisateurController::class, 'index'])->name('utilisateurs');

Route::get('/admins', [App\Http\Controllers\AdminController::class, 'admin'])->name('admins');

Route::get('/intranet/chapitre', [App\Http\Controllers\IntranetController::class, 'chapitre'])->name('chapitreIntranet');
Route::post('/intranet/cours', [App\Http\Controllers\IntranetController::class, 'cours'])->name('coursIntranet');
Route::post('/intranet/nextIfExercice', [App\Http\Controllers\IntranetController::class, 'nextIfExercice'])->name('nextIfExerciceIntranet');
Route::get('/intranet/qcm', [App\Http\Controllers\IntranetController::class, 'qcm'])->name('qcmIntranet');
Route::get('/intranet/exercice', [App\Http\Controllers\IntranetController::class, 'exercice'])->name('exerciceIntranet');
Route::post('/intranet/score', [App\Http\Controllers\IntranetController::class, 'score'])->name('scoreIntranet');
Route::post('/intranet/next', [App\Http\Controllers\IntranetController::class, 'next'])->name('nextIntranet');
Route::get('/intranet/projet', [App\Http\Controllers\IntranetController::class, 'projet'])->name('projetIntranet');
Route::post('/intranet/preIndex', [App\Http\Controllers\IntranetController::class, 'preIndex'])->name('preIndexIntranet');
Route::post('/intranet/faireProjet', [App\Http\Controllers\IntranetController::class, 'faireProjet'])->name('faireProjetIntranet');

Route::resource('intranet','App\Http\Controllers\IntranetController');
Route::resource('exercice','App\Http\Controllers\ExerciceController');
Route::resource('projet','App\Http\Controllers\ProjetController');
Route::resource('document','App\Http\Controllers\DocumentController');
Route::resource('session','App\Http\Controllers\SessionController');
Route::resource('titre','App\Http\Controllers\TitreController');
Route::resource('qcm','App\Http\Controllers\QcmController');

Route::resource('categorie','App\Http\Controllers\CategorieController');
Route::resource('matiere','App\Http\Controllers\MatiereController');
Route::resource('sousmatiere','App\Http\Controllers\SousMatiereController');
Route::resource('cv','App\Http\Controllers\CvController');

Route::resource('section','App\Http\Controllers\SectionController');
Route::resource('cursus','App\Http\Controllers\FormationAdminController');
Route::resource('cours','App\Http\Controllers\CoursController');
Route::resource('chapitre','App\Http\Controllers\ChapitreController');
Route::resource('centre','App\Http\Controllers\FormationController');
Route::resource('stagiaire','App\Http\Controllers\StagiaireController');
Route::resource('competence','App\Http\Controllers\CompetenceController');
Route::resource('parametre','App\Http\Controllers\parametreController');


Route::get('/addMatiere', [App\Http\Controllers\MatiereController::class, 'create'])->name('addMatiere');
Route::get('/categoriematiere', [App\Http\Controllers\MatiereController::class, 'categoriematiere'])->name('categoriematiere');
Route::get('/listematiere', [App\Http\Controllers\MatiereController::class, 'index'])->name('listematiere');
//Route::get('/matiere/{id}', [App\Http\Controllers\MatiereController::class, 'index'])->name('suitemodification');


Route::get('/categoriematiereetsous', [App\Http\Controllers\SousMatiereController::class, 'categoriematiereetsous'])->name('categoriematiereetsous');
Route::get('/addSousMatiere', [App\Http\Controllers\SousMatiereController::class, 'create'])->name('addSousMatiere');

Route::resource('utilisateur','App\Http\Controllers\UtilisateurController');
Route::resource('admin','App\Http\Controllers\AdminController');

