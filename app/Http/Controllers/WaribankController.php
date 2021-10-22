<?php

namespace App\Http\Controllers;
use App\Models\Menbre;
use \App\Http\Controllers\CinetpayPaiementController;

use Illuminate\Http\Request;

class WaribankController extends Controller
{
    public function index($id_menbre){
        $le_menbre = Menbre::find($id_menbre);
        return view('espace_menbre.profil.waribank',compact('le_menbre'));
    }

    public function rechargement_waribank(Request $request){
        
            //================INTEGRATION CINETPAY===================
            $la_session = session(MenbreController::$cle_session);
            $id_menbre_connecter = $la_session['id'];

            $donnees_formulaire = $request->all();

            // CONVERSION EN CFA AVANT PAIEMENT
            $le_menbre = Menbre::find($id_menbre_connecter);
            $le_montant = $donnees_formulaire['montant_recharge'];

            $wallet_menbre =  $le_menbre->compte;
            $wallet_menbre->solde = $wallet_menbre->solde + $le_montant;
            if($wallet_menbre->save()){
                $notification = "<div class='alert alert-success text-center'> votre compte a bien ete rechargé </div>";
                return redirect()->back()->with('notification',$notification);
            }

            if($le_menbre->devise_choisie->code != "XOF"){
                $monaie_createur_tontine = $le_menbre->devise_choisie->code;
                $quotient_de_conversion = \App\Http\Controllers\CurrencyConverterController::recuperer_quotient_de_conversion(
                    $monaie_createur_tontine,"XOF");
                $le_montant_en_xof = $quotient_de_conversion * $le_montant;
            }else{
                $le_montant_en_xof = $le_montant;
            }
            // CONVERSION EN CFA AVANT PAIEMENT

            
            $route_back_en_cas_derreur = route('details_projet',[1]);
            $payment_url = CinetpayPaiementController::generer_lien_paiement($le_menbre,1,$le_montant_en_xof,$le_montant,'waricrowd',$route_back_en_cas_derreur);
            return redirect($payment_url);
            //================SIMULATION LOCALE===================
    }

}
