<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationPaiementCinetPay;
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

Route::get('/retour-paiement',function(Request $request){
     $trans_id = "163275877720210927160617";
     $apikey = \App\Http\Controllers\NotificationPaiementCinetPay::$apikey;
     $site_id = \App\Http\Controllers\NotificationPaiementCinetPay::$cpm_site_id;

    $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, "https://api.cinetpay.com/v1/?method=checkPayStatus");
     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    	"Cache-Control: no-cache",
    	"content-type:application/json;charset=utf-8"
    ));
    curl_setopt($ch, CURLOPT_POST, true);

     $datas = array("apikey"=>$apikey,"cpm_site_id"=>$site_id,"cpm_trans_id"=>$trans_id);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
    	echo curl_error($ch);
    	die();
    }
    //dd($response,$apikey,$site_id);
});


Route::post('/retour-paiement',function(Request $request){
     $trans_id = $request->input('cpm_trans_id');
     $apikey = \App\Http\Controllers\NotificationPaiementCinetPay::$apikey;
     $site_id = $request->input('cpm_site_id');
     $cpm_custom = $request->input('cpm_custom');

     //recuperer le statut
/*     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, "https://www.analyse-innovation-solution-fr/404");
     curl_setopt($ch, CURLOPT_POST, true);
     $datas = array("user"=>"johndoe","user_id"=>1);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    	"Cache-Control: no-cache",
    	"content-type:application/json;charset=utf-8"
    ));
    $response = curl_exec($ch);
     */
    $b = new Transaction();
       $b->id_tontine = 5995;
       $b->id_menbre = 5995;
       $b->montant = 696;
       $b->trans_id = $trans_id;
       $b->id_menbre_qui_prend = 8008;
       $b->save();
   //notification_paiement_tontine($request);
});

Route::post("/payer-ma-cotisation/reponse-tontine",
    [NotificationPaiementCinetPay::class,'notification_paiement_tontine']
)->name('espace_menbre.notification_paiement_tontine');

Route::post("/retour-paiement-soutenir-waricrowd/reponse-cinietpay",
                [NotificationPaiementCinetPay::class,'reponse_paiement_soutenir_waricrowd'])
                ->name('espace_menbre.reponse_paiement_soutien_waricrowd');


///#==============TONTINE=====================================================================
