<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCahierRetraitSoldeMenbresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cahier_retrait_solde_menbres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_menbre');
            $table->integer('montant_retirer');
            $table->integer('solde_avant');
            $table->integer('solde_apres');
            $table->enum('statut',['REFUSED','ACCEPTED']);
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
        Schema::dropIfExists('cahier_retrait_solde_menbres');
    }
}
