<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->date('deadline1')->nullable();
            $table->date('deadline2')->nullable();
            $table->date('deadline2')->nullable();
            $table->tinyInteger('approved');
            $table->unsignedBigInteger('idGroupLeader');
            $table->tinyInteger('sendEmail1');
            $table->tinyInteger('sendEmail2');
            $table->foreign('idGroupLeader')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
};
