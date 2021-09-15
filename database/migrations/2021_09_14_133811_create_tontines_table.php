<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTontinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tontines', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('montant'); //montant a payer par personne
            $table->string('frequence_depot_en_jours');
            $table->integer('nombre_participant');
            $table->enum('etat',['ouverte','fermee']);
            $table->foreignId('id_menbre'); //menbre createur
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
        Schema::dropIfExists('tontines');
    }
}
