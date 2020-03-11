<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArtistaMusica extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('musicas', function (Blueprint $table) {
            $table->bigInteger('artista_id')->unsigned()->nullable()->index('index_musica_artista');
            $table->foreign('artista_id')->references('id')->on('artistas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('musicas', function (Blueprint $table) {
            $table->dropColumn('artista_id');
        });
    }
}
