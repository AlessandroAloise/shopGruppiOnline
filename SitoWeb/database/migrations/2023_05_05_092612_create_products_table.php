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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code',255);
            $table->string('name', 255);
            $table->string('description', 255);
            $table->longblob('image')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('quantityMin');
            $table->integer('multiple');
            $table->unsignedBigInteger('idGroup');
            $table->tinyInteger('visible');
            $table->foreign('idGroup')->references('id')->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
