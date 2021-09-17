<?php

use App\Http\Controllers\AdministrateurController;
use Illuminate\Support\Facades\Route;


//    ===================Tontines======================
Route::get("/les-tontines",[AdministrateurController::class,'les_tontines'])->name('admin.les_tontines');
Route::get("/details-tontines/{id_tontine}",[AdministrateurController::class,'details_tontine'])->name('admin.details_tontine');

Route::put("/details-tontines/changer-etat/{id_tontine}",[AdministrateurController::class,'changer_etat_tontine'])->name('admin.changer_etat_tontine');
Route::put("/les-menbres/suspendre/{id_menbre}",[AdministrateurController::class,'suspendre_menbre'])->name('admin.suspendre_menbre');


//    ===================WARICROWD======================
Route::get("/les-waricrowds/{filtre?}",[AdministrateurController::class,'les_waricrowds'])->name('admin.les_waricrowds');
Route::get("/details-crowd/{id_crowd}",[AdministrateurController::class,'details_waricrowd'])->name('admin.details_waricrowd');

Route::put("/details-waricrowd/validation/{id_tontine}",[AdministrateurController::class,'changer_etat_crowd'])->name('admin.changer_etat_crowd');

//    ===================Menbres Inscrits======================
Route::get("/liste-menbres-inscrits/{filtre?}",[AdministrateurController::class,'liste_menbres_inscrits'])->name('admin.liste_menbres_inscrits');
