<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('last_name', 250);
            $table->string('ci', 10)->unique();
            $table->string('celular', 9);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('password_text');
            $table->string('username')->unique();
            $table->boolean('active')->default(true);
            //$table->enum('rol',['Administrador','Secretario','Personal']);
            $table->integer('oficina_id')->unsigned();
            $table->foreign('oficina_id')->references('id')->on('oficinas');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
