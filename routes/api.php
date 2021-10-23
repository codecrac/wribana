<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationPaiementCinetPay;
use App\Http\Controllers\CinetpayPaiementController;
use App\Http\Controllers\CinetpayApiTransfertController;
use App\Http\Controllers\EspaceMenbre;
use App\Http\Controllers\EspaceMenbreWaricrowdController;
use App\Http\Controllers\WaribankController;
use App\Models\Transaction;
use App\Models\TransactionWaricrowd;

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

///#==============RECHARGEMENT=====================================================================
Route::get("/index_waribank/{id_menbre}",[WaribankController::class,'index']);
Route::post("/index_waribank/{id_menbre}",[WaribankController::class,'index'])->name('api.index_waribank');

Route::get("/notification_paiement_rechargement",[CinetpayPaiementController::class,'notification_paiement_rechargement']);
Route::post("/notification_paiement_rechargement",[CinetpayPaiementController::class,'notification_paiement_rechargement'])->name('api.notification_paiement_rechargement');
///#==============TONTINE=====================================================================

Route::post("/notification_paiement_cotisation_tontine",[CinetpayPaiementController::class,'notification_paiement_cotisation_tontine'])->name('api.notification_paiement_cotisation_tontine');
Route::post("/notification_paiement_cotisation_crowd",[CinetpayPaiementController::class,'notification_paiement_cotisation_crowd'])->name('api.notification_paiement_cotisation_crowd');

/*pour url retour de paiement */
Route::post("/details-tontines/{id_tontine}", function($id_tontine){
        $trans_id = $_GET['trans_id'];
        $la_transaction = \App\Models\Transaction::where('trans_id','=',$trans_id)->first();
        $statut_transaction = $la_transaction->statut;
        
        $route = route('espace_menbre.details_tontine',[$id_tontine])."?statut_transaction=$statut_transaction";
        return redirect($route);
    }
)->name('api.details_tontine');



Route::post("/payer-ma-cotisation/reponse-tontine",
    [NotificationPaiementCinetPay::class,'notification_paiement_tontine']
)->name('espace_menbre.notification_paiement_tontine');

///#==============CROWD=====================================================================
Route::post("/retour-paiement-soutenir-waricrowd/reponse-cinetpay",
    [NotificationPaiementCinetPay::class,'reponse_paiement_soutenir_waricrowd'])
    ->name('espace_menbre.reponse_paiement_soutien_waricrowd');
    
//en post pour retour de paiement
Route::post("/details-waricrowd/{id_crowd}", function($id_crowd){
        
        $trans_id = $_GET['trans_id'];
        $la_transaction = \App\Models\TransactionWaricrowd::where('trans_id','=',$trans_id)->first();
        $statut_transaction = $la_transaction->statut;
        
    
        $route = route('details_projet',[$id_crowd])."?statut_transaction=$statut_transaction";
        return redirect($route);
    })->name('api.details_waricrowd');

///#==============RETRAIT=====================================================================

Route::post("/retour-retrait-compte-menbre/reponse-cinetpay",
    [CinetpayApiTransfertController::class,'notification_retrait_compte_client'])
    ->name('api.notification_retrait_compte_client');


    //**********************MOBILE******************* */
    include "api.mobile.php";