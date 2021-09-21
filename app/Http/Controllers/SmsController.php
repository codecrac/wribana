<?php

namespace App\Http\Controllers;

use App\Models\CaisseTontine;
use App\Models\Menbre;
use App\Models\Tontine;
use App\Models\Transaction;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public static function sms_info_bip($telephone,$message)
    {
        $curl = curl_init();

        $post_field = "{'messages':[{'from':'Waribana','destinations':[{'to':'$telephone'}],'text':'$message'}]}";

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://jd988v.api.infobip.com/sms/2/text/advanced' ,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"messages":[{"from":"WARIBANA","destinations":[{"to":"'.$telephone.'"}],"text":"'.$message.'"}]}',
            CURLOPT_HTTPHEADER => array(
                'Authorization:App 27aa395694e182a0d679cc9d5feda40f-8b933270-cf0f-443b-ac7a-bc7436c00115',
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
//        echo $response ."<br/>";

    }

    public function notifier_retard_de_paiement_tontine(){
        $maintenant = date('d-m-Y');
//        dd($maintenant);

        $nombre_de_retard_en_tout = 0;
        $les_caisses_tontines_en_retard = CaisseTontine::whereHas('tontine',function ($tontine){
            $tontine->where('etat','=','ouverte');
        })->where('prochaine_date_encaissement','<=',$maintenant)->orderBy('id','desc')->get();

        foreach ($les_caisses_tontines_en_retard as $item_caisse_en_retard){
            $liste_retardataires = "";$i=0;
            $les_participants = $item_caisse_en_retard->tontine->participants;
            foreach ($les_participants as $item_participants){
                $id_menbre = $item_participants->id;
                $a_deja_cotiser = Transaction::where("id_menbre",'=',$id_menbre)
                    ->where('id_tontine','=',$item_caisse_en_retard->tontine->id)
                    ->where('id_menbre_qui_prend','=',$item_caisse_en_retard->tontine->caisse->menbre_qui_prend->id)->first();
                $a_deja_cotiser = ($a_deja_cotiser!=null) ? true : false;

                if(!$a_deja_cotiser){
                    $le_menbre = Menbre::find($id_menbre);
                    if($i>0){
                        $liste_retardataires .=", ";
                    }
                    $liste_retardataires .= "$le_menbre->nom_complet";
                    $i++;
                    $nombre_de_retard_en_tout++;
                }
            }

//            dd($liste_retardataires);
            foreach ($les_participants as $item_participant){
                $titre_tontine = $item_caisse_en_retard->tontine->titre;
                $montant = $item_caisse_en_retard->tontine->montant;
                $message = " Tontine : $titre_tontine , Retard de paiement de : $liste_retardataires";

                $numero = "225$item_participant->telephone";
                $this->sms_info_bip($numero,$message);
            }
        }

        echo "$nombre_de_retard_en_tout paiement en retard en tout";
    }
}
