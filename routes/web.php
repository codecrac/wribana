<?php

use App\Http\Controllers\EspaceMenbre;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\MenbreController;
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

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});


Route::get('/espace-menbre/confirmation',  [MenbreController::class,'confirmer_compte_menbre'])->name('espace_menbre.confirmer_compte_menbre');
Route::post('/espace-menbre/confirmation',  [MenbreController::class,'post_confirmer_compte_menbre'])->name('espace_menbre.post_confirmer_compte_menbre');

Route::get('/espace-menbre/entrer-code-de-confirmation',  [MenbreController::class,'entrer_code_confirmation'])->name('espace_menbre.entrer_code_confirmation');
Route::post('/espace-menbre/entrer-code-de-confirmation',  [MenbreController::class,'post_entrer_code_confirmation'])->name('post_espace_menbre.entrer_code_confirmation');
#===================================================================
Route::prefix('/espace-menbre')->middleware('menbre_connecter')->group(function (){
    Route::get("/",[EspaceMenbre::class,'accueil'])->name('espace_menbre.accueil');
    Route::get("/deconnexion",[EspaceMenbre::class,'deconnexion'])->name('espace_menbre.deconnexion');

    Route::get("/mon-compte/{id_menbre}",[EspaceMenbre::class,'profil'])->name('espace_menbre.profil');
    Route::post("/mon-compte/{id_menbre}",[EspaceMenbre::class,'modifier_profil'])->name('espace_menbre.post_profil');

//    ===================Tontines======================
    Route::get("/mes-tontines",[EspaceMenbre::class,'liste_tontine'])->name('espace_menbre.liste_tontine');
    Route::get("/details-tontines/{id_tontine}",[EspaceMenbre::class,'details_tontine'])->name('espace_menbre.details_tontine');
    Route::post("/details-tontines/{id_tontine}",[EspaceMenbre::class,'ouvrir_tontine'])->name('espace_menbre.ouvrir_tontine');

    Route::get("/inviter-des-amis-dans-la-tontine/{id_tontine}",[EspaceMenbre::class,'inviter_des_amis'])->name('espace_menbre.inviter_des_amis');
    Route::post("/inviter-des-amis-dans-la-tontine/{id_tontine}",[EspaceMenbre::class,'envoyer_invitation'])->name('espace_menbre.post_inviter_des_amis');

    Route::get("/editer-une-tontine/{id_tontine}",[EspaceMenbre::class,'editer_tontine'])->name('espace_menbre.editer_tontine');
    Route::put("/editer-une-tontine/{id_tontine}",[EspaceMenbre::class,'modifier_tontine'])->name('espace_menbre.post_editer_tontine');

    Route::get("/creer-une-tontine",[EspaceMenbre::class,'ajouter_tontine'])->name('espace_menbre.ajouter_tontine');
    Route::post("/creer-une-tontine",[EspaceMenbre::class,'enregistrer_tontine'])->name('espace_menbre.post_ajouter_tontine');


    Route::get("/invitations",[EspaceMenbre::class,'invitations'])->name('espace_menbre.invitations');
    Route::post("/invitations/{id_invitation}",[EspaceMenbre::class,'reponse_invitation'])->name('espace_menbre.reponse_invitation');
    Route::post("/invitations-via-code",[EspaceMenbre::class,'adhesion_via_code_invitation'])->name('espace_menbre.adhesion_via_code_invitation');

    Route::post("/payer-ma-cotisation/{id_tontine}",[EspaceMenbre::class,'paiement_cotisation'])->name('espace_menbre.paiement_cotisation');


    Route::get("/recu_de_paiement_tontine",[EspaceMenbre::class,'recu_de_paiement_tontine'])->name('espace_menbre.recu_de_paiement');
    Route::get("/chat/{id_tontine}",[EspaceMenbre::class,'chat_tontine'])->name('espace_menbre.chat_tontine');
    Route::post("/chat/{id_tontine}",[EspaceMenbre::class,'chat_tontine_envoyer_message'])->name('espace_menbre.chat_tontine_envoyer_message');
    //    ===================WARICROWD======================
    include 'waricrowd_route.php';
});
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
