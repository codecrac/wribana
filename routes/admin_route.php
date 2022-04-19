<?php

use App\Http\Controllers\AdministrateurController;
use Illuminate\Support\Facades\Route;


Route::middleware('etat_compte_admin')->group(function(){
    
    //    ===================GESTIONNAIRE======================
    Route::middleware('only_admin')->group(function(){
        Route::get("/les-gestionnaire",[AdministrateurController::class,'les_gestionnaire'])->name('admin.gestionnaire');
        Route::post("/les-gestionnaire",[AdministrateurController::class,'enregistrer_gestionnaire'])->name('admin.enregistrer_gestionnaire');
        Route::put("/les-gestionnaire/{id}",[AdministrateurController::class,'modifier_gestionnaire'])->name('admin.modifier_gestionnaire');
    });
    
    //    ===================Tontines======================
    Route::middleware('only_gest_tontine')->group(function(){
        Route::get("/les-tontines",[AdministrateurController::class,'les_tontines'])->name('admin.les_tontines');
        Route::get("/details-tontines/{id_tontine}",[AdministrateurController::class,'details_tontine'])->name('admin.details_tontine');
        Route::get("/historique-transactions/tontines",[AdministrateurController::class,'historique_transactions_tontine'])->name('admin.historique_transactions_tontine');
        Route::get("/historique-versements-au-menbres",[AdministrateurController::class,'historique_versements'])->name('admin.historique_versements');
        Route::put("/details-tontines/changer-etat/{id_tontine}",[AdministrateurController::class,'changer_etat_tontine'])->name('admin.changer_etat_tontine');
        Route::put("/les-menbres/suspendre/{id_menbre}",[AdministrateurController::class,'suspendre_menbre'])->name('admin.suspendre_menbre');
    });
    
    
    //    ===================WARICROWD======================
    Route::middleware('only_gest_crowd')->group(function(){
        Route::get("/waricrowd/categories",[AdministrateurController::class,'ajouter_categorie_waricrowd'])->name('admin.ajouter_categorie_waricrowd');
        Route::post("/waricrowd/categories",[AdministrateurController::class,'enregistrer_categorie_waricrowd'])->name('admin.post_ajouter_categorie_waricrowd');
        Route::put("/waricrowd/categories/editer/{id_categorie}",[AdministrateurController::class,'modifier_categorie_waricrowd'])->name('admin.modifier_categorie_waricrowd');
        Route::get("/waricrowd/categories/effacer/{id_categorie}",[AdministrateurController::class,'effacer_categorie_waricrowd'])->name('admin.effacer_categorie_waricrowd');
        Route::get("/les-waricrowds/{filtre?}",[AdministrateurController::class,'les_waricrowds'])->name('admin.les_waricrowds');
        Route::get("/details-crowd/{id_crowd}",[AdministrateurController::class,'details_waricrowd'])->name('admin.details_waricrowd');
        Route::get("/editer-le-waricrowd/{id_crowd}",[AdministrateurController::class,'editer_crowd'])->name('admin.editer_crowd');
        Route::post("/editer-le-waricrowd/{id_crowd}",[AdministrateurController::class,'modifier_un_waricrowd'])->name('admin.modifier_un_waricrowd');
        Route::get("/historique-transactions/waricrowd",[AdministrateurController::class,'historique_transactions_waricrowd'])->name('admin.historique_transactions_waricrowd');
    });
    
    Route::put("/details-waricrowd/validation/{id_tontine}",[AdministrateurController::class,'changer_etat_crowd'])->name('admin.changer_etat_crowd');
    
    Route::middleware('only_admin')->group(function(){
        //    ===================Menbres Inscrits======================
        Route::get("/liste-menbres-inscrits/{filtre?}",[AdministrateurController::class,'liste_menbres_inscrits'])->name('admin.liste_menbres_inscrits');
        Route::get("/historique-retraits-compte-menbres",[AdministrateurController::class,'historique_retraits'])->name('admin.historique_retraits');
        Route::get("/historique-profil",[AdministrateurController::class,'historique_profil'])->name('admin.historique_profil');
        
        
        //    ===================PARAMETRE======================
        Route::get("/notifications/definir-contenu",[AdministrateurController::class,'definir_contenu_notifications'])->name('admin.definir_contenu_notifications');
        Route::post("/notifications/definir-contenu",[AdministrateurController::class,'post_definir_contenu_notifications'])->name('admin.post_definir_contenu_notifications');
        
        Route::get("/parametre/definir-valeur",[AdministrateurController::class,'parametre'])->name('admin.parametre');
        Route::post("/parametre/definir-valeur",[AdministrateurController::class,'post_parametre'])->name('admin.post_parametre');
    });
    
    
});

Route::get('deconnexion',function(){
    return view('administrateur/compte_suspendu');
})->name('admin.deconnexion');
