
<?php

use App\Models\Waricrowd;
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

});
