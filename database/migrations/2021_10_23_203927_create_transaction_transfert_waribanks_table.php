<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTransfertWaribanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_transfert_waribanks', function (Blueprint $table) {
            $table->id();
            $table->integer('id_menbre');
            $table->integer('id_destinataire');
            $table->string('telephone');
            $table->integer('montant_monaie_expediteur');
            $table->integer('montant_equivalent_destinataire');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_transfert_waribanks');
    }
}
