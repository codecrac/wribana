<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devises', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('symbole');
            $table->string('monaie');
        });

        DB::table('devises')->insert(
            array(
                'code' => 'XOF',
                'symbole' => 'FCFA',
                'monaie' => 'FCFA',
            )
        );
        DB::table('devises')->insert(
            array(
                'code' => 'USD',
                'symbole' => '$',
                'monaie' => 'dollards',
            )
        );
        DB::table('devises')->insert(array(
                'code' => 'EUR',
                'symbole' => '€',
                'monaie' => 'euros'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devises');
    }
}
