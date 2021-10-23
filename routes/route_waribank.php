<?php


use App\Http\Controllers\WaribankController;

    Route::get("/mon-compte-waribank/{id_menbre}",[WaribankController::class,'index'])->name('espace_menbre.index_waribank');
    Route::post("/mon-compte-waribank/rechargement",[WaribankController::class,'rechargement_waribank'])->name('espace_menbre.rechargement_waribank');
    Route::post("/mon-compte-waribank/confirmer-transfert",[WaribankController::class,'confirmer_waribank'])->name('espace_menbre.confirmer_waribank');
    Route::post("/mon-compte-waribank/effectuer_tranfert_waribank",[WaribankController::class,'effectuer_tranfert_waribank'])->name('espace_menbre.effectuer_tranfert_waribank');
?>
