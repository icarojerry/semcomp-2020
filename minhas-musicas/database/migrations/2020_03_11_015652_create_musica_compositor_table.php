<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMusicaCompositorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('musica_compositor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('musica_id')->unsigned()->index('index_musica_compositor_musica');
            $table->integer('compositor_id')->unsigned()->index('index_musica_compositor_compositor');
            $table->timestamps();

            $table->index(['musica_id', 'compositor_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('musica_compositor');
    }
}
