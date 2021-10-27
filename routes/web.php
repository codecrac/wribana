<?php

use App\Http\Controllers\CinetpayPaiementController;
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

Route::get('/connexion-membre', [MenbreController::class,'connexion_menbre'])->name('connexion_menbre');
Route::get('/inscription-membre', [MenbreController::class,'inscription_menbre'])->name('inscription_menbre');

Route::post('/inscription-membre', [MenbreController::class,'enregistrer_un_menbre'])->name('post_inscription_menbre');
Route::post('/connexion-membre',  [MenbreController::class,'connexion'])->name('post_connexion_menbre');
Route::get('/reinitialiser-mot-de-passe',  [MenbreController::class,'reinitialiser_mot_de_passe'])->name('reinitialiser_mot_de_passe');
Route::post('/reinitialiser-mot-de-passe',  [MenbreController::class,'post_reinitialiser_mot_de_passe'])->name('post_reinitialiser_mot_de_passe');



Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
    Artisan::call('route:clear');
    Artisan::call('optimize');
});


Route::get('/espace-membre/confirmation',  [MenbreController::class,'confirmer_compte_menbre'])->name('espace_menbre.confirmer_compte_menbre');
Route::post('/espace-membre/confirmation',  [MenbreController::class,'post_confirmer_compte_menbre'])->name('espace_menbre.post_confirmer_compte_menbre');
Route::post('/espace-membre/definir-ma-devise',  [MenbreController::class,'post_choisir_devise'])->name('espace_menbre.post_choisir_devise');

Route::get('/espace-membre/entrer-code-de-confirmation',  [MenbreController::class,'entrer_code_confirmation'])->name('espace_menbre.entrer_code_confirmation');
Route::post('/espace-membre/entrer-code-de-confirmation',  [MenbreController::class,'post_entrer_code_confirmation'])->name('post_espace_menbre.entrer_code_confirmation');

#===================================================================
                        #espace-membre
#===================================================================
Route::prefix('/espace-membre')->middleware('menbre_connecter')->group(function (){

//    ===================PROFIL MENBRES======================
    include 'profil_espace_menbre_route.php';

//    ===================COMPTE WALLET======================
    include 'route_waribank.php';

//    ===================Tontines======================
    include 'tontine_espace_menbre_route.php';

 //    ===================WARICROWD======================
    include 'waricrowd_route.php';
});

Route::get("/deconnexion",[EspaceMenbre::class,'deconnexion'])->name('espace_menbre.deconnexion');



Route::get("/generer-lien-de-paiement",[CinetpayPaiementController::class,'generer_lien_paiement'])->name('generer_lien_paiement');
//la route de notification est une api
Route::get("/recup_statut_paiement_cinetpay",[CinetpayPaiementController::class,'recup_statut_paiement_cinetpay'])->name('recup_statut_paiement_cinetpay');


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
