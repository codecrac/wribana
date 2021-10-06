<?php

use App\Http\Controllers\EspaceMenbreWaricrowdController;
use Illuminate\Support\Facades\Route;


//    ===================WARICROWD======================
Route::get("/mes-waricrowd",[EspaceMenbreWaricrowdController::class,'liste_waricrowd'])->name('espace_menbre.liste_waricrowd');

Route::get("/creer-un-waricrowd",[EspaceMenbreWaricrowdController::class,'creer_un_waricrowd'])->name('espace_menbre.creer_un_waricrowd');
Route::post("/creer-un-waricrowd",[EspaceMenbreWaricrowdController::class,'enregistrer_un_waricrowd'])->name('espace_menbre.post_creer_un_waricrowd');

Route::get("/editer-le-waricrowd/{id_crowd}",[EspaceMenbreWaricrowdController::class,'editer_crowd'])->name('espace_menbre.editer_crowd');
Route::post("/editer-le-waricrowd/{id_crowd}",[EspaceMenbreWaricrowdController::class,'modifier_un_waricrowd'])->name('espace_menbre.post_editer_crowd');

Route::get("/supprimer-une-waricrowd/{id_tontine}", [EspaceMenbreWaricrowdController::class, 'supprimer_waricrowd'])->name('espace_menbre.supprimer_waricrowd');
Route::delete("/supprimer-une-waricrowd/{id_tontine}", [EspaceMenbreWaricrowdController::class, 'post_supprimer_waricrowd'])->name('espace_menbre.post_supprimer_waricrowd');

Route::get("/details-waricrowd/{id_crowd}",[EspaceMenbreWaricrowdController::class,'details_waricrowd'])->name('espace_menbre.details_waricrowd');
//en post pour retour de paiement
Route::post("/details-waricrowd/{id_crowd}",[EspaceMenbreWaricrowdController::class,'details_waricrowd']);
Route::get("/editer-waricrowd/{id_crowd}",[EspaceMenbreWaricrowdController::class,'editer_crowd'])->name('espace_menbre.editer_crowd');

Route::post("/soutenir-projet/{id_crowd}",[EspaceMenbreWaricrowdController::class,'soutenir_projet'])->name('espace_menbre.soutenir_projet');
Route::post("/confirmation-de-soutien-wricrowd",[EspaceMenbreWaricrowdController::class,'confirmation_soutien_waricrowd'])->name('espace_menbre.confirmation_soutien_waricrowd');


Route::get("/projets-soutenus",[EspaceMenbreWaricrowdController::class,'projets_soutenus'])->name('espace_menbre.projets_soutenus');
