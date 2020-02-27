<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompositoresMusica extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('musicas', function (Blueprint $table) {
            $table->bigInteger('compositor_id')->unsigned()->nullable();
            $table->foreign('compositor_id')->references('id')->on('compositores')->onDelete('cascade');
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
            $table->dropColumn('compositor_id');
        });
    }
}
