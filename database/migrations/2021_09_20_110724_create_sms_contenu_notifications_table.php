<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsContenuNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_contenu_notifications', function (Blueprint $table) {
            $table->id();
            $table->text('confirmation_compte');
            $table->text('etat_waricowd');
            $table->text('etat_tontine');
            $table->text('invitation_recue');
            $table->text('virement_compte_menbre_qui_prend');
            $table->text('retard_paiement');
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
        Schema::dropIfExists('sms_contenu_notifications');
    }
}
