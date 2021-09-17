<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaricrowdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waricrowds', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_menbre"); //proprietaire
            $table->string("titre");
            $table->string("description_courte");
            $table->text("description_complete");
            $table->integer("montant_objectif")->nullable();
            $table->string("lien_pitch_video")->nullable();
            $table->string("image_illustration")->default('images/waricrowd/statiques/crowfunding.png');
            $table->enum("etat",['attente','valider','recaler','terminer','annuler']);
            $table->string("motif_intervention_admin")->nullable();
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
        Schema::dropIfExists('waricrowds');
    }
}
