<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionRechargementWaribanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_rechargement_waribanks', function (Blueprint $table) {
            $table->id();
            $table->integer('id_menbre');
            $table->integer('solde_avant');
            $table->integer('montant');
            $table->integer('solde_apres');
            $table->text('trans_id');
            $table->enum('statut',['PENDING','ACCEPTED','REFUSED']);
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
        Schema::dropIfExists('transaction_rechargement_waribanks');
    }
}
