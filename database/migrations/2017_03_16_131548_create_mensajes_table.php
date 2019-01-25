<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMensajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from_user_id')->unsigned();
            $table->integer('to_user_id')->unsigned();
            $table->enum('estado',['Enviado','Recivido','Visto']);
            $table->foreign('from_user_id')->references('id')->on('users');
            $table->foreign('to_user_id')->references('id')->on('users');
            $table->string('mensaje');
            $table->string('asunto');
            $table->timestamps();
        });
        Schema::create('planilla_mensajes', function (Blueprint $table) {
            $table->integer('mensaje_id')->unsigned();
            $table->integer('documento_id')->unsigned();
            $table->foreign('documento_id')->references('id')->on('documentos');
            $table->foreign('mensaje_id')->references('id')->on('mensajes');
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
        Schema::dropIfExists('planilla_mensajes');
        Schema::dropIfExists('mensajes');

    }
}
