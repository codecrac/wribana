<?php

use App\Http\Controllers\EspaceMenbre;

Route::get("/mes-tontines", [EspaceMenbre::class, 'liste_tontine'])->name('espace_menbre.liste_tontine');
Route::get("/details-tontines/{id_tontine}", [EspaceMenbre::class, 'details_tontine'])->name('espace_menbre.details_tontine');
//pour retour de paiement
Route::post("/details-tontines/{id_tontine}", [EspaceMenbre::class, 'details_tontine']);
Route::post("/details-tontines/{id_tontine}", [EspaceMenbre::class, 'ouvrir_tontine'])->name('espace_menbre.ouvrir_tontine');

Route::get("/inviter-des-amis-dans-la-tontine/{id_tontine}", [EspaceMenbre::class, 'inviter_des_amis'])->name('espace_menbre.inviter_des_amis');
Route::post("/inviter-des-amis-dans-la-tontine/{id_tontine}", [EspaceMenbre::class, 'envoyer_invitation'])->name('espace_menbre.post_inviter_des_amis');

Route::get("/editer-une-tontine/{id_tontine}", [EspaceMenbre::class, 'editer_tontine'])->name('espace_menbre.editer_tontine');
Route::put("/editer-une-tontine/{id_tontine}", [EspaceMenbre::class, 'modifier_tontine'])->name('espace_menbre.post_editer_tontine');
Route::get("/supprimer-une-tontine/{id_tontine}", [EspaceMenbre::class, 'supprimer_tontine'])->name('espace_menbre.supprimer_tontine');
Route::delete("/supprimer-une-tontine/{id_tontine}", [EspaceMenbre::class, 'post_supprimer_tontine'])->name('espace_menbre.post_supprimer_tontine');

Route::get("/creer-une-tontine", [EspaceMenbre::class, 'ajouter_tontine'])->name('espace_menbre.ajouter_tontine');
Route::post("/creer-une-tontine", [EspaceMenbre::class, 'enregistrer_tontine'])->name('espace_menbre.post_ajouter_tontine');


Route::get("/invitations", [EspaceMenbre::class, 'invitations'])->name('espace_menbre.invitations');
Route::post("/invitations/{id_invitation}", [EspaceMenbre::class, 'reponse_invitation'])->name('espace_menbre.reponse_invitation');
Route::post("/invitations-via-code", [EspaceMenbre::class, 'adhesion_via_code_invitation'])->name('espace_menbre.adhesion_via_code_invitation');

Route::post("/payer-ma-cotisation/{id_tontine}", [EspaceMenbre::class, 'paiement_cotisation'])->name('espace_menbre.paiement_cotisation');


Route::get("/recu_de_paiement_tontine", [EspaceMenbre::class, 'recu_de_paiement_tontine'])->name('espace_menbre.recu_de_paiement');
Route::get("/chat/{id_tontine}", [EspaceMenbre::class, 'chat_tontine'])->name('espace_menbre.chat_tontine');
Route::post("/chat/{id_tontine}", [EspaceMenbre::class, 'chat_tontine_envoyer_message'])->name('espace_menbre.chat_tontine_envoyer_message');
Route::get("/qui-est-en-ligne/{id_tontine}", [EspaceMenbre::class, 'chat_tontine_qui_est_en_ligne'])->name('espace_menbre.chat_tontine_qui_est_en_ligne');

?>
