<?php

namespace App\Http\Controllers;
use App\Models\Waricrowd;
use App\Models\Menbre;
use App\Models\Invitation;
use App\Models\Tontine;
use Illuminate\Http\Request;

class MobileApiController extends Controller
{
    public function liste_crowd($index_pagination=0){
        $les_crowds = Waricrowd::with('categorie')->with('createur')->with('caisse')->skip($index_pagination)->limit(25)->get();
        return $les_crowds;
        return json_encode($les_crowds);
    }

    public function connexion(Request $request){
        
        $message = "";
        $reponse = [
            'success'=>false,
            'message'=>$message
        ];
        $donnees_formulaire = $request->all();
        
        $prefixe = $donnees_formulaire['prefixe'];
        $telephone = $donnees_formulaire['telephone'];
        // $identifiant = $donnees_formulaire['identifiant'];
        $identifiant = $prefixe . $telephone;
        $mot_de_passe = $donnees_formulaire['mot_de_passe'];

        $mot_de_passe_caher = md5($mot_de_passe);

        $le_menbre = Menbre::where('email', '=', $identifiant)
            ->orWhere('telephone', '=', $identifiant) ->first();

        if ($le_menbre != null) {
            if( $mot_de_passe_caher == $le_menbre->mot_de_passe ){
                $reponse['success'] = true;
                $message = "connecte";
                $reponse["message"] = $message;
                $reponse = $this->creer_session_menbre($reponse,$le_menbre);
            }else{
                $message = "mot de passe Incorrect";
                $reponse["message"] = $message;
            }
        } else {
            $message = "Identifiant ou Mot de passe Incorrect";
            $reponse["message"] = $message;
        }

        
        return json_encode($reponse);

    }

    public function infos_pour_tableau_de_bord($id_menbre){
        $le_menbre = Menbre::find($id_menbre);
        // dd($le_menbre);
        $email_inviter = $le_menbre->email;
        $invitation_recues = [];
        if($email_inviter!=null){
            $nb_invitation_recues = Invitation::where('email_inviter','=',$email_inviter)->where('etat','=','attente')->count();
        }

        $infos_pour_tableau_de_bord = [];
        $infos_pour_tableau_de_bord['nb_tontine'] = sizeof($le_menbre->tontines);
        $infos_pour_tableau_de_bord['nb_invitations_recues'] = $nb_invitation_recues;
        $infos_pour_tableau_de_bord['nb_waricrowd'] = sizeof($le_menbre->mes_waricrowd);
        $infos_pour_tableau_de_bord['nb_projets_soutenus'] = sizeof($le_menbre->projets_soutenus);
        $infos_pour_tableau_de_bord['solde'] = $le_menbre->compte->solde ." ". $le_menbre->devise_choisie->monaie;
        // return $infos_pour_tableau_de_bord;
        return json_encode($infos_pour_tableau_de_bord);
    }

    public function liste_tontine($id_menbre){
        $les_tontines = Tontine::with('createur')->where('id_menbre','=',$id_menbre)->orderBy('id','desc')->get();
        return json_encode($les_tontines);
    }





////===================UTILITAIRES=========================
    private function creer_session_menbre($reponse,$le_menbre)
    {
        $id_menbre = $le_menbre->id;
        $nom_complet = $le_menbre->nom_complet;
        $email = $le_menbre->email;
        $telephone = $le_menbre->telephone;
        if($le_menbre->devise_choisie !=null){
            $devise = $le_menbre->devise_choisie->monaie;
            $code_devise = $le_menbre->devise_choisie->code;
        }else{
            $devise ='---';
            $code_devise ='--';
        }
        
        $reponse['utilisateur'] = ['id' => $id_menbre,
         'nom_complet' => $nom_complet,
          'devise' => $devise,
          'code_devise'=>$code_devise,
          'email'=>$email,
          'telephone'=>$telephone,
        ];
        return $reponse;
    }
}
