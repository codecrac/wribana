<?php

use App\Http\Controllers\EspaceMenbre;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\MenbreController;
use App\Http\Controllers\NotificationPaiementCinetPay;
use App\Models\StatistiqueFrequentation;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;


/*
|********* |*********|********* Routes  Vitrine |*********|*********|*********
|********* |*********|********* Routes  Vitrine |*********|*********|*********
*/



Route::get('/', [FrontController::class,'accueil'])->name('accueil');

Route::get('/projets-waricrowd', [FrontController::class,'decouvrir_projets'])->name('decouvrir_projets');

Route::get('/details-projet/{id_crowd}', [FrontController::class,'details_projet'])->name('details_projet');

Route::get('/comment-ca-marche', [FrontController::class,'comment_ca_marche'])->name('comment_ca_marche');

Route::get('/qui-sommes-nous', [FrontController::class,'apropos'])->name('apropos');

Route::get('/faq', [FrontController::class,'faq'])->name('faq');

Route::get('/contactez-nous', [FrontController::class,'contact'])->name('contact');

Route::get('/connexion-menbre', [MenbreController::class,'connexion_menbre'])->name('connexion_menbre');
Route::get('/inscription-menbre', [MenbreController::class,'inscription_menbre'])->name('inscription_menbre');

Route::post('/inscription-menbre', [MenbreController::class,'enregistrer_un_menbre'])->name('post_inscription_menbre');
Route::post('/connexion-menbre',  [MenbreController::class,'connexion'])->name('post_connexion_menbre');
Route::get('/reinitialiser-mot-de-passe',  [MenbreController::class,'reinitialiser_mot_de_passe'])->name('reinitialiser_mot_de_passe');
Route::post('/reinitialiser-mot-de-passe',  [MenbreController::class,'post_reinitialiser_mot_de_passe'])->name('post_reinitialiser_mot_de_passe');


Route::post('/', [FrontController::class,'accueil'])->name('accueil');//pour le retour apres paiement sur cinetpay
Route::post('/projets-waricrowd', [FrontController::class,'decouvrir_projets'])->name('decouvrir_projets');//pour le retour apres paiement sur cinetpay
Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});


Route::get('/espace-menbre/confirmation',  [MenbreController::class,'confirmer_compte_menbre'])->name('espace_menbre.confirmer_compte_menbre');
Route::post('/espace-menbre/confirmation',  [MenbreController::class,'post_confirmer_compte_menbre'])->name('espace_menbre.post_confirmer_compte_menbre');
Route::post('/espace-menbre/definir-ma-devise',  [MenbreController::class,'post_choisir_devise'])->name('espace_menbre.post_choisir_devise');

Route::get('/espace-menbre/entrer-code-de-confirmation',  [MenbreController::class,'entrer_code_confirmation'])->name('espace_menbre.entrer_code_confirmation');
Route::post('/espace-menbre/entrer-code-de-confirmation',  [MenbreController::class,'post_entrer_code_confirmation'])->name('post_espace_menbre.entrer_code_confirmation');

#===================================================================
                        #espace-menbre
#===================================================================
Route::prefix('/espace-menbre')->middleware('menbre_connecter')->group(function (){

//    ===================PROFIL MENBRES======================
    include 'profil_espace_menbre_route.php';

//    ===================Tontines======================
    include 'tontine_espace_menbre_route.php';

 //    ===================WARICROWD======================
    include 'waricrowd_route.php';
});

Route::get("/deconnexion",[EspaceMenbre::class,'deconnexion'])->name('espace_menbre.deconnexion');



Route::post("/payer-ma-cotisation/reponse-tontine",[NotificationPaiementCinetPay::class,'notification_paiement_tontine'])->name('espace_menbre.notification_paiement_tontine');
Route::post("/retour-paiement-soutenir-waricrowd/reponse-cinietpay",
                [NotificationPaiementCinetPay::class,'reponse_paiement_soutenir_waricrowd'])
                ->name('espace_menbre.reponse_paiement_soutien_waricrowd');
Route::get("/notifier-les-retards-de-paiement-sur-tontine",[\App\Http\Controllers\SmsController::class,'notifier_retard_de_paiement_tontine'])->name('tontine.notifier_retard_de_paiement_tontine');


//    ===================Administrateur======================

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $nombre_tontine = \App\Models\Tontine::count();

    $nombre_waricrowd = \App\Models\Waricrowd::count();
    $nombre_waricrowd_attente = \App\Models\Waricrowd::where('etat','=','attente')->count();

    $nombre_menbre= \App\Models\Menbre::count();
    $nombre_menbre_banni= \App\Models\Menbre::where('etat','=','suspendu')->count();

    $statistique_frequentation = StatistiqueFrequentation::orderBy('id','desc')->limit(5)->get();
    return view('dashboard',compact('nombre_tontine','nombre_waricrowd',
        'nombre_menbre','nombre_waricrowd_attente','nombre_menbre_banni','statistique_frequentation'));
})->name('dashboard');

Route::prefix('administrateur')->middleware(['auth:sanctum', 'verified'])->group(function (){
    include 'admin_route.php';
});
