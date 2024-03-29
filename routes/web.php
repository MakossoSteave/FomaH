<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response; 
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
try {

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

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/formationshow', [App\Http\Controllers\formationshowController::class, 'index'])->name('formationshow');
Route::get('message/{id}', [
    'as' => 'message',
    'uses' => 'App\Http\Controllers\messageController@index',
    'message'
]);
Route::get('/Ajoutforma', [App\Http\Controllers\FormationController::class, 'create'])->name('Ajoutforma');
Route::get('/formation/{id}', [App\Http\Controllers\FormationController::class, 'show'])->name('oneFormation');

Route::get('/cours', [App\Http\Controllers\CoursController::class, 'index'])->name('cours');
Route::get('/cours/{id}', [App\Http\Controllers\CoursController::class, 'filter'])->name('coursFilter');
Route::get('/addCours', [App\Http\Controllers\CoursController::class, 'create'])->name('addCours');
Route::get('/etatCours/{id}', [App\Http\Controllers\CoursController::class, 'etat'])->name('etatCours');

Route::get('/chapitres/{id}', [App\Http\Controllers\ChapitreController::class, 'index'])->name('chapitres');
Route::get('/addChapitre/{id}', [App\Http\Controllers\ChapitreController::class, 'create'])->name('addChapitre');
Route::get('/etatChapitre/{id}', [App\Http\Controllers\ChapitreController::class, 'etat'])->name('etatChapitre');

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
Route::get('/qcmStagiaire/{id}/{idSession}', [App\Http\Controllers\SessionController::class, 'qcmStagiaire'])->name('qcmStagiaire');
Route::get('/qcmViewStagiaire/{id}', [App\Http\Controllers\SessionController::class, 'qcmViewStagiaire'])->name('qcmViewStagiaire');
Route::get('/projetStagiaire/{id}/{idSession}', [App\Http\Controllers\SessionController::class, 'projetStagiaire'])->name('projetStagiaire');
Route::get('/projetViewStagiaire/{id}', [App\Http\Controllers\SessionController::class, 'projetViewStagiaire'])->name('projetViewStagiaire');
Route::get('/projetStagiaireModifierResultat/{id_projet}/{id_stagiaire}/{idSession}', [App\Http\Controllers\SessionController::class, 'projetStagiaireModifierResultat'])->name('projetStagiaireModifierResultat');
Route::post('/editResultProjetStagiaire/{id_projet}/{id_stagiaire}', [App\Http\Controllers\SessionController::class, 'editResultProjetStagiaire'])->name('editResultProjetStagiaire');
Route::delete('/deleteResultProjetStagiaire/{id_projet}/{id_stagiaire}', [App\Http\Controllers\SessionController::class, 'deleteResultProjetStagiaire'])->name('deleteResultProjetStagiaire');
Route::get('/Session_Projet/{id}', [App\Http\Controllers\SessionController::class, 'Session_Projet'])->name('Session_Projet');
Route::get('/editProjet/{id_projet}/{idSession}', [App\Http\Controllers\SessionController::class, 'editProjet'])->name('editProjet');
Route::put('/projetUpdate/{id_projet}/{idSession}', [App\Http\Controllers\SessionController::class, 'projetUpdate'])->name('projetUpdate');

Route::get('/document/{id}', [App\Http\Controllers\DocumentController::class, 'index'])->name('document');
Route::get('/addDocument/{id}', [App\Http\Controllers\DocumentController::class, 'create'])->name('addDocument');

Route::get('/projet/{id}', [App\Http\Controllers\ProjetController::class, 'index'])->name('projet');
Route::get('/addProjet/{id}', [App\Http\Controllers\ProjetController::class, 'create'])->name('addProjet');
Route::get('/etatProjet/{id}', [App\Http\Controllers\ProjetController::class, 'etat'])->name('etatProjet');
Route::delete('/deleteDocument/{id}', [App\Http\Controllers\ProjetController::class, 'deleteDocument'])->name('deleteDocument');

Route::get('/viewTitre/{id}', [App\Http\Controllers\TitreController::class, 'view'])->name('viewTitre');

Route::get('/exercice/{id}', [App\Http\Controllers\ExerciceController::class, 'index'])->name('exercice');
Route::get('/addExercice/{id}', [App\Http\Controllers\ExerciceController::class, 'create'])->name('addExercice');
Route::get('/etatExercice/{id}', [App\Http\Controllers\ExerciceController::class, 'etat'])->name('etatExercice');
Route::delete('/deleteQuestionExercice/{id}', [App\Http\Controllers\ExerciceController::class, 'deleteQuestionExercice'])->name('deleteQuestionExercice');

Route::get('/stagiaires', [App\Http\Controllers\StagiaireController::class, 'stagiaire'])->name('stagiaires');
Route::get('/addStagiaire', [App\Http\Controllers\StagiaireController::class, 'create'])->name('addStagiaire');

Route::get('/utilisateurs', [App\Http\Controllers\UtilisateurController::class, 'index'])->name('utilisateurs');

Route::get('/admins', [App\Http\Controllers\AdminController::class, 'admin'])->name('admins');

Route::get('/intranet/chapitre', [App\Http\Controllers\IntranetController::class, 'oneChapitre'])->name('chapitreIntranet');
Route::post('/intranet/cours', [App\Http\Controllers\IntranetController::class, 'cours'])->name('coursIntranet');
Route::post('/intranet/nextIfExercice', [App\Http\Controllers\IntranetController::class, 'nextIfExercice'])->name('nextIfExerciceIntranet');
Route::get('/intranet/qcm', [App\Http\Controllers\IntranetController::class, 'qcm'])->name('qcmIntranet');
Route::get('/intranet/exercice', [App\Http\Controllers\IntranetController::class, 'exercice'])->name('exerciceIntranet');
Route::post('/intranet/score', [App\Http\Controllers\IntranetController::class, 'score'])->name('scoreIntranet');
Route::post('/intranet/next', [App\Http\Controllers\IntranetController::class, 'next'])->name('nextIntranet');
Route::get('/intranet/projet', [App\Http\Controllers\IntranetController::class, 'projet'])->name('projetIntranet');
Route::post('/intranet/preIndex', [App\Http\Controllers\IntranetController::class, 'preIndex'])->name('preIndexIntranet');
Route::post('/intranet/faireProjet', [App\Http\Controllers\IntranetController::class, 'faireProjet'])->name('faireProjetIntranet');
Route::get('/intranet/previousChapter', [App\Http\Controllers\IntranetController::class, 'previousChapter'])->name('previousChapterIntranet');
Route::get('/intranet/chapitres/{id}', [App\Http\Controllers\IntranetController::class, 'onePreviousChapter'])->name('onePreviousChapter');
Route::get('/intranet/previousQCM', [App\Http\Controllers\IntranetController::class, 'previousQCM'])->name('previousQCMIntranet');
Route::get('/intranet/qcms/{id}', [App\Http\Controllers\IntranetController::class, 'onePreviousQCM'])->name('onePreviousQCMIntranet');
Route::get('/intranet/previousExercices', [App\Http\Controllers\IntranetController::class, 'previousExercices'])->name('previousExercicesIntranet');
Route::get('/intranet/exercices/{id}', [App\Http\Controllers\IntranetController::class, 'onePreviousExercice'])->name('onePreviousExerciceIntranet');
Route::get('/intranet/previousProjets', [App\Http\Controllers\IntranetController::class, 'previousProjets'])->name('previousProjetsIntranet');
Route::get('/intranet/projets/{id}', [App\Http\Controllers\IntranetController::class, 'onePreviousProjet'])->name('onePreviousProjetIntranet');
Route::get('/intranet/live', [App\Http\Controllers\IntranetController::class, 'live'])->name('liveIntranet');
Route::get('/intranet/statutLive', [App\Http\Controllers\IntranetController::class, 'statutLive'])->name('statutLiveIntranet');
Route::get('/intranet/coursSuivant', [App\Http\Controllers\IntranetController::class, 'coursSuivant'])->name('coursSuivant');

Route::get('/intranet/formateurs/lives', [App\Http\Controllers\IntranetFormateurController::class, 'live'])->name('live_formateur');
Route::post('/intranet/formateurs/lives', [App\Http\Controllers\IntranetFormateurController::class, 'createLive'])->name('create_live_formateur');
Route::get('/intranet/formateurs/projets', [App\Http\Controllers\IntranetFormateurController::class, 'projet'])->name('projet_formateur')
;
Route::get('/intranet/formateurs/projet/{id}', [App\Http\Controllers\IntranetFormateurController::class, 'oneProjet'])->name('one_projet_formateur')
;
Route::post('/intranet/formateurs/projetGrade', [App\Http\Controllers\IntranetFormateurController::class, 'projetGrade'])->name('grade_project')
;

Route::get('storage/{filename}', function ($filename)
{
    $path = storage_path('public/' . $filename);
 
    if (!File::exists($path)) {
        abort(404);
    }
 
    $file = File::get($path);
    $type = File::mimeType($path);
 
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
 
    return $response;
});

Route::resource('intranetFormateur','App\Http\Controllers\IntranetFormateurController');
Route::resource('intranet','App\Http\Controllers\IntranetController');
Route::resource('exercice','App\Http\Controllers\ExerciceController');
Route::resource('projet','App\Http\Controllers\ProjetController');
Route::resource('document','App\Http\Controllers\DocumentController');
Route::resource('session','App\Http\Controllers\SessionController');
Route::resource('titre','App\Http\Controllers\TitreController');
Route::resource('qcm','App\Http\Controllers\QcmController');
Route::resource('categorie','App\Http\Controllers\CategorieController');
Route::resource('section','App\Http\Controllers\SectionController');
Route::resource('cursus','App\Http\Controllers\FormationAdminController');
Route::resource('cours','App\Http\Controllers\CoursController');
Route::resource('chapitre','App\Http\Controllers\ChapitreController');
Route::resource('centre','App\Http\Controllers\FormationController');
Route::resource('stagiaire','App\Http\Controllers\StagiaireController');
Route::resource('utilisateur','App\Http\Controllers\UtilisateurController');
Route::resource('admin','App\Http\Controllers\AdminController');
Route::resource('parametre','App\Http\Controllers\parametreController');

} catch(ReflectionException $e) {
    // use custom /resources/views/errors/404.blade.php to display $pageName
    // View::share('pageName', $nameFormat);
    abort(404, "Not found");
}