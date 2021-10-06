<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationPaiementCinetPay;
use App\Http\Controllers\CinetpayPaiementController;
use App\Http\Controllers\CinetpayApiTransfertController;
use App\Models\Transaction;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

///#==============TONTINE=====================================================================
//Route::get("/notification_paiement_cotisation_tontine",[CinetpayPaiementController::class,'notification_paiement_cotisation_tontine'])->name('notification_paiement_cotisation_tontine');
Route::post("/notification_paiement_cotisation_tontine",[CinetpayPaiementController::class,'notification_paiement_cotisation_tontine'])->name('notification_paiement_cotisation_tontine');
Route::post("/notification_paiement_cotisation_crowd",[CinetpayPaiementController::class,'notification_paiement_cotisation_crowd'])->name('notification_paiement_cotisation_crowd');


Route::post("/payer-ma-cotisation/reponse-tontine",
    [NotificationPaiementCinetPay::class,'notification_paiement_tontine']
)->name('espace_menbre.notification_paiement_tontine');

///#==============CROWD=====================================================================
Route::post("/retour-paiement-soutenir-waricrowd/reponse-cinetpay",
    [NotificationPaiementCinetPay::class,'reponse_paiement_soutenir_waricrowd'])
    ->name('espace_menbre.reponse_paiement_soutien_waricrowd');


///#==============RETRAIT=====================================================================

Route::post("/retour-retrait-compte-menbre/reponse-cinetpay",
    [CinetpayApiTransfertController::class,'notification_retrait_compte_client'])
    ->name('api.notification_retrait_compte_client');
