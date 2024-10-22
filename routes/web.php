<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\SelectController;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\StatuController;
use App\Http\Controllers\SuggestionMessageController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PosteController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\ClassementController;
use App\Http\Controllers\EntretienController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\File;

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
    return view('auth_recruteur/login');
});

Route::middleware(['auth', 'role:0'])->group(function () {

    Route::controller(PageController::class)->group(function () {
        Route::get('/home', 'showHome')->name('showHome');

        Route::get('/email', 'showEmail')->name('showEmail');
        
    });

    Route::controller(NotificationController::class)->group(function () {
        Route::get('/getNotification', 'getNotification')->name('notification.getListe');
        Route::get('/getNotif/{id_recruteur}', 'getNotificationRecruteur')->name('notification.getNotificationRecruteur');
        Route::get('/updateNotif/{id_recruteur}', 'update_notification')->name('notification.updateNotification');
        Route::get('/deleteNotif/{id_recruteur}/{id_notification}', 'delete_notification_recruteur')->name('notification.delete');



    });

    Route::controller(SelectController::class)->group(function () {
        // afficher formulaire d'insertion des  -> cv physique ou avec import
        Route::get('/formulaire', 'liste_formulaire')->name('showFormulaire');
        Route::get('/formulaire_import', 'formulaire_importation')->name('showImport');

        // afficher liste candidats
        Route::get('/candidat', 'liste_candidat')->name('showCandidats');

        // afficher formulaire de modification de candidat
        Route::get('/modifier/{id}', 'liste_modifier')->name('candidat.modifier');

        // afficher cv d'un candidat
        Route::get('/cv/{id}', 'afficher_cv')->name('candidat.cv');

        // pour la recherche et filtre
        Route::get('/find', 'recherche')->name('candidat.recherche');

        // afficher formulaire de modification de statu d'un candidat
        Route::get('/formulaire_candidat_statu/{id}/{statu}', 'liste_modifier_statu')->name('candidat.formulaire_statu');

    });

    Route::controller(CandidatController::class)->group(function () {
        //inserer candidat
        Route::post('/insert_candidat', 'insertCandidat')->name('candidat.insert');

        //udpate candidat
        Route::post('/update_candidat', 'updateCandidat')->name('candidat.update');

        // insertion et upload CV
        Route::post('/upload_cv', 'uploadCv')->name('candidat.import');
        

    });

    Route::controller(StatuController::class)->group(function () {

        Route::post('/update_candidat_statu', 'updateStatu')->name('candidat.update_statu');

        Route::get('/delete_historique/{id}', 'delete_historique')->name('statu.delete');

    });

    Route::controller(MailController::class)->group(function () {
        Route::Get('/send_email', 'SendEmailAction')->name('email.send');
        Route::Get('/email_form', 'Formulaire')->name('email.formulaire');
        Route::Get('/get_email/{id}', 'get_email')->name('email.getmail');
        Route::Get('/get_suggestion/{id}', 'get_suggestion')->name('email.get_suggestion');
        Route::Get('/parametre_form', 'Formulaire_parametre')->name('email.parametre_form');
        Route::Get('/parametre_update', 'updateParametre')->name('email.parametre_update');
        Route::Get('/testa', 'testa')->name('email.par');
    });

    Route::controller(SuggestionMessageController::class)->group(function () {
        Route::Get('/suggestion_index', 'index')->name('suggestion.index');
        Route::Get('/suggestion_update_form/{id}', 'update_form')->name('suggestion.update_form');
        Route::Get('/suggestion_delete/{id}', 'delete_suggestion')->name('suggestion.delete');
        Route::Get('/suggestion_update', 'update_suggestion')->name('suggestion.update');
        Route::Get('/suggestion_create', 'insert_suggestion')->name('suggestion.create');

    });

    Route::controller(PosteController::class)->group(function () {
        Route::Get('/poste_index', 'index')->name('poste.index');
        Route::Get('/poste_insert_form', 'insert_form')->name('poste.formulaire');
        Route::Get('/poste_create', 'insert_poste')->name('poste.create');
        Route::Get('/poste_delete/{id}', 'delete')->name('poste.delete');

    });

    Route::controller(QuestionController::class)->group(function () {
        Route::get('/formulaire_questionnaire', 'formulaire')->name('question.formulaire');
        Route::get('/formulaire_modification/{id}', 'formulaire_modification')->name('question.formulaire_modification');
        Route::get('/liste_questionnaire', 'test')->name('question.liste');
        Route::post('/question_insert', 'insert')->name('question.insert'); 
        Route::get('/questionnaire_delete/{id}', 'delete')->name('question.delete');
        Route::post('/question_modifier', 'update')->name('question.update');
        Route::get('/triage_question', 'tri_question')->name('question.tri');

    });

    Route::controller(StatistiqueController::class)->group(function () {
        Route::get('/show_statistique', 'index')->name('statistique.index');
        Route::get('/get_stat_genre/{annee}', 'parGenre')->name('statistique.parGenre');
        Route::get('/get_stat_poste/{annee}/{mois}', 'parMoisPoste')->name('statistique.parPoste');
        Route::get('/get_stat_statut/{annee}/{mois}', 'parStatut')->name('statistique.parStatut');
    });

    Route::controller(EntretienController::class)->group(function () {
        Route::get('/liste_candidat_entretien', 'liste_user')->name('entretien.liste');
        Route::get('/formulaire_envoie/{id}', 'Question_form')->name('entretien.envoyer');
        Route::get('/supprimer_user/{id}', 'delete')->name('entretien.delete');
        Route::post('/envoie_questionnaire', 'insert_questionnaire')->name('entretien.insert');
        Route::get('/getFiche/{id_user}/{id_poste}', 'getFiche')->name('entretien.getFiche');
        Route::get('/getListeReponse/{id_user}', 'getListeReponseAdmin')->name('entretien.getListeReponse');

        Route::post('/genererClassement', 'genererClassement')->name('entretien.genererClassement');
    });

    Route::controller(ClassementController::class)->group(function () {
        Route::get('/listeClassement', 'index')->name('classement.index');
        Route::post('/recherche/listeClassement', 'classement_poste')->name('classement.filtre');

    });

});

Route::middleware(['auth', 'role:1'])->group(function () {
    Route::controller(ClientController::class)->group(function () {
        Route::get('/home_candidat', 'index')->name('client.Home');
    });

    Route::controller(EntretienController::class)->group(function () {
        Route::get('/question/{id_user}/{id_poste}', 'getQuestion')->name('entretien.getQuestion');
        Route::post('/entretien_save', 'insert_entretien')->name('entretien.save');
        Route::get('/ma_fiche/{id_user}/{id_poste}', 'getReponse')->name('entretien.getReponse');
        Route::get('/liste/{id_user}', 'getListe')->name('entretien.getListe');
        Route::get('/liste_fiche/{id_user}', 'getListeReponse')->name('entretien.getListeFiche');

    });

});

// tsisy middleware

// Route::controller(CvController::class)->group(function () {
//     Route::post('upload', 'uploadCv')->name('upload.uploadCv');
//     // afficher liste de cv pout test
//     Route::get('/cv', 'cv_liste')->name('showListeCv');

// });

Route::controller(PageController::class)->group(function () {
    // pour afficher login et register des clients
    Route::get('/registerForm', 'register_form')->name('showRegister');
    Route::get('/loginForm', 'login_form')->name('showLogin');

    // pour afficher login et register des recruteurs
    Route::get('/registerAdmin', 'register_form_admin')->name('showRegister_admin');
    Route::get('/loginAdmin', 'login_form_employee')->name('showLogin_employee');

    //tester l'affichage pour upload 
    Route::get('/show_upload', 'showUpload')->name('cv.showUpload');

    Route::get('/showCv', 'showCV')->name('cv.showCv');

});

Route::controller(AuthController::class)->group(function () {
    // register pour admin
    Route::get('/registerAdminAction', 'register_Admin')->name('employee.register');
    // register pour client
    Route::get('/registerClientAction', 'register_client')->name('client.register');
    // un seul action pour Admin et client
    Route::post('/loginAction', 'loginAction')->name('loginAction');
    // logout pour admin et client
    Route::get('/logout', 'logout')->name('logoutAction');
});