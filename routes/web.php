<?php

use App\Http\Controllers\EspaceMenbre;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\MenbreController;
use Illuminate\Support\Facades\Route;

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

    Route::post("/payer-ma-cotisation/{id_tontine}",[EspaceMenbre::class,'paiement_cotisation'])->name('espace_menbre.paiement_cotisation');

    //    ===================WARICROWD======================
    include 'waricrowd_route.php';
});


//    ===================Administrateur======================

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $nombre_tontine = \App\Models\Tontine::count();

    $nombre_waricrowd = \App\Models\Waricrowd::count();
    $nombre_waricrowd_attente = \App\Models\Waricrowd::where('etat','=','attente')->count();

    $nombre_menbre= \App\Models\Menbre::count();
    $nombre_menbre_banni= \App\Models\Menbre::where('etat','=','suspendu')->count();
    return view('dashboard',compact('nombre_tontine','nombre_waricrowd','nombre_menbre','nombre_waricrowd_attente','nombre_menbre_banni'));
})->name('dashboard');

Route::prefix('administrateur')->middleware(['auth:sanctum', 'verified'])->group(function (){
    include 'admin_route.php';
});
