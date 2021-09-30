<?php


use App\Http\Controllers\EspaceMenbre;

Route::get("/",[EspaceMenbre::class,'accueil'])->name('espace_menbre.accueil');

    Route::get("/mon-compte/{id_menbre}",[EspaceMenbre::class,'profil'])->name('espace_menbre.profil');
    Route::post("/mon-compte/{id_menbre}",[EspaceMenbre::class,'modifier_profil'])->name('espace_menbre.post_profil');
    Route::post("/modifier-telephone-compte",[EspaceMenbre::class,'modifier_telephone_compte'])->name('espace_menbre.modifier_telephone_compte');
    Route::get("/entrer-code-confirmation-pour-modification", [EspaceMenbre::class,'entrer_code_confirmation_pour_modification'])->name('espace_menbre.entrer_code_confirmation_pour_modification');
    Route::post("/entrer-code-confirmation-pour-modification", [EspaceMenbre::class,'post_entrer_code_confirmation_pour_modification'])->name('espace_menbre.post_entrer_code_confirmation_pour_modification');

    Route::post("/confirmation-retrait-dargent",[EspaceMenbre::class,'confirmer_retrait_dargent'])->name('espace_menbre.confirmer_retrait_dargent');

?>
