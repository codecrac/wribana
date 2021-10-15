
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
    Route::get("/connexion",[MobileApiController::class,'connexion']);
    Route::get("/infos_pour_tableau_de_bord/{id_menbre}",[MobileApiController::class,'infos_pour_tableau_de_bord']);
    Route::get("/liste_tontine/{id_menbre}",[MobileApiController::class,'liste_tontine']);
    Route::get("/details_tontine/{id_tontine}/{id_menbre_connecter}",[MobileApiController::class,'details_tontine']);
    Route::get("/adhesion_via_code_invitation/{identifiant_adhesion}/{id_menbre}",[MobileApiController::class,'adhesion_via_code_invitation']);
    Route::get("/ouvrir_tontine/{id_tontine}",[MobileApiController::class,'ouvrir_tontine']);
    Route::get("/paiement_cotisation/{id_tontine}/{id_menbre}",[MobileApiController::class,'paiement_cotisation']);


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
