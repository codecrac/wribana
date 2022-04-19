<?php

namespace App\Http\Controllers;

use App\Models\CaisseTontine;
use App\Models\Menbre;
use App\Models\SmsContenuNotification;
use App\Models\Tontine;
use App\Models\Transaction;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public static function sms_info_bip($telephone,$message)
    {
        $curl = curl_init();

        $post_field = "{'messages':[{'from':'Waribana','destinations':[{'to':'$telephone'}],'text':'$message'}]}";

//remplace api-key-here par api key
        
        $date_time= date(now());
        // dd($date_time);
        
        // API INFO sms nmtechnologie
         $param = array(
        'username' => 'WARIBANA',
        'password' => 'w@ribana114',
        'sender' => 'WARIBANA',
        'text' => $message,
        'type' => 'text',
        'datetime' => $date_time,
    );
    $recipients = array("$telephone");
    $post = 'to=' . implode(';', $recipients);
    foreach ($param as $key => $val) {
        $post .= '&' . $key . '=' . rawurlencode($val);
    }
    $url = "https://sms.nmtechnologie.com/api/api_http.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Connection: close"));
    $result = curl_exec($ch);
    if(curl_errno($ch)) {
        $result = "cURL ERROR: " . curl_errno($ch) . " " . curl_error($ch);
    } else {
        $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        switch($returnCode) {
            case 200 :
                break;
            default :
                $result = "HTTP ERROR: " . $returnCode;
        }
    }
    curl_close($ch);
    

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

            $headers = 'From: waribana@waribana.net' . "\r\n" .
                 'Reply-To: no-reply@waribana.net' . "\r\n" .
                 'X-Mailer: PHP/' . phpversion();
            foreach ($les_participants as $item_participant){
                $titre_tontine = $item_caisse_en_retard->tontine->titre;
                $montant = $item_caisse_en_retard->tontine->montant;


                $base_message = SmsContenuNotification::first();
                $message = $base_message['retard_paiement'];
                $message = str_replace('$titre$',$titre_tontine,$message);
                $message = str_replace('$liste_retardataires$',$liste_retardataires,$message);

                $numero = "$item_participant->telephone";
                $this->sms_info_bip($numero,$message);
                mail($item_participants->email,"RETARD DE PAIEMENT SUR TONTINE << $titre_tontine >>",$message,$headers);
            }
        }

        echo "$nombre_de_retard_en_tout paiement en retard en tout [ $liste_retardataires ]";
    }
}
