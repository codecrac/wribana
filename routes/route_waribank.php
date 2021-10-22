<?php


use App\Http\Controllers\WaribankController;

    Route::get("/mon-compte-waribank/{id_menbre}",[WaribankController::class,'index'])->name('espace_menbre.index_waribank');
    Route::post("/mon-compte-waribank/rechargement",[WaribankController::class,'rechargement_waribank'])->name('espace_menbre.rechargement_waribank');
?>
