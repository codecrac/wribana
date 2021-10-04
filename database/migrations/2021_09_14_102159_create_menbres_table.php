<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenbresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menbres', function (Blueprint $table) {
            $table->id();
            $table->string("nom_complet");
            $table->string("telephone")->unique();
            $table->string("email")->nullable()->unique();
            $table->string("mot_de_passe");
            $table->enum("etat",['attente','actif','suspendu']);
            $table->string('motif_intervention_admin')->nullable();
            $table->string('date_derniere_visite')->nullable();
            $table->string('devise')->nullable();
            $table->integer('code_de_confirmation');
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
        Schema::dropIfExists('menbres');
    }
}
