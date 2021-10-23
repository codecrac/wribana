<?php

namespace App\Http\Controllers;
use App\Models\Menbre;
use App\Models\TransactionTransfertWaribank;
use \App\Http\Controllers\CinetpayPaiementController;
use \App\Http\Controllers\SmsController;

use Illuminate\Http\Request;

class WaribankController extends Controller
{
    public function index($id_menbre){
        $le_menbre = Menbre::find($id_menbre);
        return view('espace_menbre.profil.waribank',compact('le_menbre'));
    }

    public function rechargement_waribank(Request $request)
    {
        
        
            //================INTEGRATION CINETPAY===================
            $la_session = session(MenbreController::$cle_session);
            $id_menbre_connecter = $la_session['id'];

            $donnees_formulaire = $request->all();
            $le_montant = $donnees_formulaire['montant_recharge'];

            $le_menbre = Menbre::find($id_menbre_connecter);
            // CONVERSION EN CFA AVANT PAIEMENT
            if($le_menbre->devise_choisie->code != "XOF"){
                $monaie_createur_tontine = $le_menbre->devise_choisie->code;
                $quotient_de_conversion = \App\Http\Controllers\CurrencyConverterController::recuperer_quotient_de_conversion(
                    $monaie_createur_tontine,"XOF");
                $le_montant_en_xof = $quotient_de_conversion * $le_montant;
            }else{
                $le_montant_en_xof = $le_montant;
            }
            // CONVERSION EN CFA AVANT PAIEMENT
            $route_back_en_cas_derreur = route('api.index_waribank',[$id_menbre_connecter]);
            $payment_url = CinetpayPaiementController::generer_lien_paiement($le_menbre,$le_montant_en_xof,$le_montant,$route_back_en_cas_derreur);
            return redirect($payment_url);
    }

    public function confirmer_waribank(Request $request)
    {
        $df = $request->all();
        $mot_de_passe_actuel = $df['mot_de_passe_actuel'];
        $prefixe = $df['prefixe'];
        $telephone = $df['telephone'];
        $montant_en_monaie_expediteur = $df['montant'];
        $numero_complet = $prefixe . $telephone;

        
        $la_session = session(MenbreController::$cle_session);
        $id_menbre_connecter = $la_session['id'];
        $le_menbre = Menbre::find($id_menbre_connecter);
        
        $bon_mot_de_passe = $this->VerifieLeMotDePasse($mot_de_passe_actuel,$le_menbre->id);
        if($bon_mot_de_passe){
            $le_destinataire = Menbre::where('telephone','=',$numero_complet)->first();
            if($le_destinataire !=null){
                if( $le_menbre->compte->solde >= $montant_en_monaie_expediteur){

                    // CONVERSION EN CFA AVANT PAIEMENT
                    if($le_menbre->devise_choisie->code != $le_destinataire->devise_choisie->code){
                        $quotient_de_conversion = \App\Http\Controllers\CurrencyConverterController::recuperer_quotient_de_conversion(
                            $le_menbre->devise_choisie->code ,$le_destinataire->devise_choisie->code);
                        $le_montant_equivalent_pour_destinataire = $quotient_de_conversion * $montant_en_monaie_expediteur;
                    }else{
                        $le_montant_equivalent_pour_destinataire = $montant_en_monaie_expediteur;
                    }

                    $id_destinataire = $le_destinataire->id;
                    return view("espace_menbre/profil/confimer_transfert_waribank",
                    compact('le_menbre','numero_complet','le_destinataire','montant_en_monaie_expediteur','le_montant_equivalent_pour_destinataire'));
                }else{
                    $notification = "<div class='alert alert-danger text-center'> Votre solde est insuffisant. </div>";    
                }
            }else{
                $notification = "<div class='alert alert-danger text-center'> Ce numero ($numero_complet) n'est associé a aucun compte </div>";
            }
        }else{
            $notification = "<div class='alert alert-danger text-center'> Mot de passe actuel incorrect </div>";
        }
        return redirect()->back()->with('notification',$notification);
    }


    public function effectuer_tranfert_waribank(Request $request)
    {
        $df = $request->all();
        $numero_destinataire = $df['numero_destinataire'];
        $id_destinataire = $df['id_destinataire'];
        $montant_en_monaie_expediteur = $df['montant_expediteur'];
        $le_montant_equivalent_pour_destinataire = $df['montant_destinataire'];

        
        $la_session = session(MenbreController::$cle_session);
        $id_menbre_connecter = $la_session['id'];
        $le_menbre = Menbre::find($id_menbre_connecter);
        $le_destinataire = Menbre::find($id_destinataire);
        
        $compte_expediteur = $le_menbre->compte;
        $compte_expediteur->solde = $compte_expediteur->solde - $montant_en_monaie_expediteur;
        $compte_expediteur->save();
        $monaie_exp = $le_menbre->devise_choisie->monaie;
        $le_message_exp = "Votre transfert de $montant_en_monaie_expediteur $monaie_exp a $le_destinataire->nom_complet ($numero_destinataire) a bien été éffectué";
        SmsController::sms_info_bip($le_menbre->telephone, $le_message_exp);

        $compte_destinataire = $le_destinataire->compte;
        $compte_destinataire->solde = $compte_destinataire->solde + $le_montant_equivalent_pour_destinataire;
        $compte_destinataire->save();
        $monaie_dest = $le_destinataire->devise_choisie->monaie;
        $le_message_dest = "Vous avez reçu un tranfert de $le_montant_equivalent_pour_destinataire $monaie_dest de $le_menbre->nom_complet";
        SmsController::sms_info_bip($le_destinataire->telephone, $le_message_dest);

        $la_transaction = new TransactionTransfertWaribank();
        $la_transaction->id_menbre = $le_menbre->id;
        $la_transaction->id_destinataire = $le_destinataire->id;
        $la_transaction->telephone = $numero_destinataire;
        $la_transaction->montant_monaie_expediteur = $montant_en_monaie_expediteur;
        $la_transaction->montant_equivalent_destinataire = $le_montant_equivalent_pour_destinataire;
        $la_transaction->save();

        $notification = "<div class='alert alert-success text-center'> Transfert bien effectué. </div>";

        return redirect()->route('espace_menbre.index_waribank',[$id_menbre_connecter])->with('notification',$notification);
    }


    //=========================UTILITAIRE
    
    private function VerifieLeMotDePasse($mdp,$id_menbre){
        $mdp_cacher = md5($mdp);
        $menbre_existant = Menbre::where('mot_de_passe','=',$mdp_cacher)->where('id','=',$id_menbre)->first();
        if($menbre_existant != null){
            return true;
        }else{
            return false;
        }
    }
}
