<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaisseTontinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caisse_tontines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tontine');
            $table->integer('montant')->default(0);
            $table->integer('montant_objectif');
            $table->integer('frais_de_gestion');
            $table->integer('montant_a_verser');
            $table->integer('id_menbre_qui_prend');
            $table->integer('index_menbre_qui_prend')->default(0);
            $table->string('prochaine_date_encaissement');
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
        Schema::dropIfExists('caisse_tontines');
    }
}
