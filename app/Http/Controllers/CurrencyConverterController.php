<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurrencyConverterController extends Controller
{
    public static function recuperer_quotient_de_conversion($from_currency,$to_currency){
        $apikey = '6441d9b217f8a6674225';
    
        $from_Currency = urlencode($from_currency);
        $to_Currency = urlencode($to_currency);
        $query =  "{$from_Currency}_{$to_Currency}";
    
        // change to the free URL if you're using the free version
        $query = urlencode($query);
        $apikey = urlencode($apikey);
        $url = "https://free.currconv.com/api/v7/convert?q=$query&compact=ultra&apiKey=$apikey";
    
        try{
            $json = file_get_contents($url);
            $obj = json_decode($json, true);
            $val = floatval($obj["$query"]);
            return $val;
        }catch(Exception $e){
            return 'erreur';
        }
    
    }

    public static function convertir_si_necessaire($quotient,$montant,$monaie_dans_laquel_on_converti){
        if($quotient != 1){
            $equivalent = $quotient * $montant;
            $reponse = "<b>($equivalent $monaie_dans_laquel_on_converti)</b>";
            return $reponse;
        }
    }
    
}
