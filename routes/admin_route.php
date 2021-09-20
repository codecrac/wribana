<?php

use App\Http\Controllers\AdministrateurController;
use Illuminate\Support\Facades\Route;


//    ===================Tontines======================
Route::get("/les-tontines",[AdministrateurController::class,'les_tontines'])->name('admin.les_tontines');
Route::get("/details-tontines/{id_tontine}",[AdministrateurController::class,'details_tontine'])->name('admin.details_tontine');
Route::get("/historique-transactions/tontines",[AdministrateurController::class,'historique_transactions_tontine'])->name('admin.historique_transactions_tontine');

Route::put("/details-tontines/changer-etat/{id_tontine}",[AdministrateurController::class,'changer_etat_tontine'])->name('admin.changer_etat_tontine');
Route::put("/les-menbres/suspendre/{id_menbre}",[AdministrateurController::class,'suspendre_menbre'])->name('admin.suspendre_menbre');


//    ===================WARICROWD======================
Route::get("/waricrowd/categories",[AdministrateurController::class,'ajouter_categorie_waricrowd'])->name('admin.ajouter_categorie_waricrowd');
Route::post("/waricrowd/categories",[AdministrateurController::class,'enregistrer_categorie_waricrowd'])->name('admin.post_ajouter_categorie_waricrowd');
Route::put("/waricrowd/categories/editer/{id_categorie}",[AdministrateurController::class,'modifier_categorie_waricrowd'])->name('admin.modifier_categorie_waricrowd');
Route::get("/waricrowd/categories/effacer/{id_categorie}",[AdministrateurController::class,'effacer_categorie_waricrowd'])->name('admin.effacer_categorie_waricrowd');

Route::get("/les-waricrowds/{filtre?}",[AdministrateurController::class,'les_waricrowds'])->name('admin.les_waricrowds');
Route::get("/details-crowd/{id_crowd}",[AdministrateurController::class,'details_waricrowd'])->name('admin.details_waricrowd');
Route::get("/historique-transactions/waricrowd",[AdministrateurController::class,'historique_transactions_waricrowd'])->name('admin.historique_transactions_waricrowd');

Route::put("/details-waricrowd/validation/{id_tontine}",[AdministrateurController::class,'changer_etat_crowd'])->name('admin.changer_etat_crowd');

//    ===================Menbres Inscrits======================
Route::get("/liste-menbres-inscrits/{filtre?}",[AdministrateurController::class,'liste_menbres_inscrits'])->name('admin.liste_menbres_inscrits');


//    ===================WARICROWD======================
Route::get("/notifications/definir-contenu",[AdministrateurController::class,'definir_contenu_notifications'])->name('admin.definir_contenu_notifications');
Route::post("/notifications/definir-contenu",[AdministrateurController::class,'post_definir_contenu_notifications'])->name('admin.post_definir_contenu_notifications');
