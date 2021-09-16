<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaisseWaricrowdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caisse_waricrowds', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_waricrowd");
            $table->integer("montant_objectif");
            $table->integer("montant")->default(0);
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
        Schema::dropIfExists('caisse_waricrowds');
    }
}
