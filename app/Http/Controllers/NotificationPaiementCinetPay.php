<?php

namespace App\Http\Controllers;

use App\Models\WaricrowdMenbre;
use App\Models\CaisseWaricrowd;
use App\Models\CategorieWaricrowd;
use App\Models\CaisseTontine;
use App\Models\Menbre;
use App\Models\Waricrowd;
use App\Models\Tontine;
use App\Models\Transaction;
use App\Models\TransactionWaricrowd;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PHPMailer\PHPMailer\PHPMailer;


class NotificationPaiementCinetPay extends Controller
{

    public static $apikey = '164337344557daee019215c2.65958011';
    public static $cpm_site_id = '750304';
    public static $mdp_api_transfert = 'Succes$$2039';

    public function api14()
    {
        //$a = Transaction::all();
        //return $a;
        $b = new Transaction();
        $b->id_tontine = 55;
        $b->id_menbre = 55;
        $b->montant = 66;
        $b->id_menbre_qui_prend = 88;
        $b->save();

        // return Transaction::all();
    }


}
