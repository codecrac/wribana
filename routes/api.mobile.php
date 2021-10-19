
<?php

use App\Models\Waricrowd;
use App\Models\Transaction;
use App\Http\Controllers\MobileApiController;

Route::prefix('/mobile')->group(function(){

    // Route::get('/liste-crowd/{index_pagination?}', function ($index_pagination=0) {
    //     $les_crowds = Waricrowd::with('categorie')->with('createur')->with('caisse')->skip($index_pagination)->limit(25)->get();
    //     return $les_crowds;
    //     return json_encode($les_crowds);
    // });

    Route::get("/liste-crowd/{index_pagination?}",[MobileApiController::class,'liste_crowd']);
    
    //utilisateur
    Route::post("/enregistrer_un_menbre",[MobileApiController::class,'enregistrer_un_menbre']);
    Route::get("/connexion",[MobileApiController::class,'connexion']);
    Route::get("/details_menbre/{id_menbre}",[MobileApiController::class,'details_menbre']);
    Route::post("/confirmer_compte_menbre/{id_menbre}",[MobileApiController::class,'confirmer_compte_menbre']);
    Route::post("/entrer_code_de_confirmation_et_choisir_devise/{id_menbre}",[MobileApiController::class,'entrer_code_de_confirmation_et_choisir_devise']);
    Route::get("/infos_pour_tableau_de_bord/{id_menbre}",[MobileApiController::class,'infos_pour_tableau_de_bord']);
    Route::get("/details_profil_utilisateur/{id_menbre}",[MobileApiController::class,'details_profil_utilisateur']);
    Route::post("/modifier_infos_genrale_dun_menbre/{id_menbre}",[MobileApiController::class,'modifier_infos_genrale_dun_menbre']);
    Route::post("/modifier_mot_de_passe_dun_menbre/{id_menbre}",[MobileApiController::class,'modifier_mot_de_passe_dun_menbre']);
    Route::post("/modifier_telephone_compte/{id_menbre}",[MobileApiController::class,'modifier_telephone_compte']);
    Route::get("/reinitialiser_mot_de_passe/{identifiant}",[MobileApiController::class,'reinitialiser_mot_de_passe']);

    //tontine
    Route::get("/adhesion_via_code_invitation/{identifiant_adhesion}/{id_menbre}",[MobileApiController::class,'adhesion_via_code_invitation']);
    Route::post("/envoyer_invitation_via_sms/{id_tontine}/{id_menbre}",[MobileApiController::class,'envoyer_invitation_via_sms']);
    Route::post("/envoyer_invitation_via_email/{id_tontine}/{id_menbre}",[MobileApiController::class,'envoyer_invitation_via_email']);
    Route::get("/invitations_recues/{id_menbre}",[MobileApiController::class,'invitations_recues']);
    Route::get("/repondre_a_une_invitation/{id_invitation}/{id_menbre}/{reponse}",[MobileApiController::class,'repondre_a_une_invitation']);


    Route::post("/creer_tontine/{id_menbre}",[MobileApiController::class,'enregistrer_tontine']);
    Route::post("/modifier_tontine/{id_tontine}",[MobileApiController::class,'modifier_tontine']);
    Route::post("/supprimer_la_tontine/{id_tontine}/{id_menbre}",[MobileApiController::class,'supprimer_la_tontine']);
    Route::get("/liste_tontine/{id_menbre}",[MobileApiController::class,'liste_tontine']);
    Route::get("/details_tontine/{id_tontine}/{id_menbre_connecter}",[MobileApiController::class,'details_tontine']);
    Route::get("/ouvrir_tontine/{id_tontine}",[MobileApiController::class,'ouvrir_tontine']);

    Route::get("/paiement_cotisation/{id_tontine}/{id_menbre}",[MobileApiController::class,'paiement_cotisation']);

//waricrowd
Route::get("/mes_waricrowds/{id_menbre}",[MobileApiController::class,'liste_waricrowd_dutilisateur']);
Route::get("/liste_projet_soutenus/{id_menbre}",[MobileApiController::class,'liste_projet_soutenus']);
Route::get("/liste_categorie_crowd",[MobileApiController::class,'liste_categorie_crowd']);
Route::get("/details_waricrowd/{id_crowd}/{id_menbre?}",[MobileApiController::class,'details_waricrowd']);

Route::get("/paiement_soutien_waricrowd/{id_crowd}/{id_menbre}",[MobileApiController::class,'paiement_soutien_waricrowd']);
Route::post("/paiement_soutien_waricrowd/{id_crowd}/{id_menbre}",[MobileApiController::class,'paiement_soutien_waricrowd']);

Route::post("/creer_waricrowd/{id_menbre}",[MobileApiController::class,'enregistrer_un_waricrowd']);
Route::post("/modifier_un_waricrowd/{id_crowd}/{id_menbre}",[MobileApiController::class,'modifier_un_waricrowd']);
Route::post("/supprimer_waricrowd/{id_crowd}/{id_menbre}",[MobileApiController::class,'supprimer_waricrowd']);



//===========================
    Route::get("/statut-transaction/",function(){
        return view("api/statut_transaction");
    })->name("api.mobile.statut_transaction");

    Route::post("/statut-transaction/",function(){
        $trans_id = $_GET['trans_id'];
        $la_transaction = \App\Models\Transaction::where('trans_id','=',$trans_id)->first();
        $statut_transaction = $la_transaction->statut;
        
        $route = route('api.mobile.statut_transaction')."?statut_transaction=$statut_transaction";
        return redirect($route); //remener sur la route en get
    });

});
