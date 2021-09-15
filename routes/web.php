<?php

use App\Http\Controllers\EspaceMenbre;
use App\Http\Controllers\MenbreController;
use Illuminate\Support\Facades\Route;

/*
|********* |*********|********* Routes  Vitrine |*********|*********|*********
|********* |*********|********* Routes  Vitrine |*********|*********|*********
*/

Route::get('/', function () {
    $is_home=true; return view('welcome',['is_home'=>$is_home]);
})->name('accueil');

Route::get('/comment-ca-marche', function () {
    $current=true; return view('comment_ca_marche',['is_comment_ca_marche'=>$current]);
})->name('comment_ca_marche');

Route::get('/qui-sommes-nous', function () {
    $current=true; return view('apropos',['is_apropos'=>$current]);
})->name('apropos');

Route::get('/faq', function () {
    $current=true; return view('faq',['is_faq'=>$current]);
})->name('faq');

Route::get('/contact', function () {
    $current=true; return view('contact',['is_contact'=>$current]);
})->name('contact');

Route::get('/connexion-menbre', function () { return view('connexion_menbre'); })->name('connexion_menbre');

Route::get('/inscription-menbre', function () {return view('inscription_menbre');})->name('inscription_menbre');

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
//    ===================Tontines======================

    Route::post("/payer-ma-cotisation/{id_tontine}",[EspaceMenbre::class,'paiement_cotisation'])->name('espace_menbre.paiement_cotisation');
});



Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
