<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery__photos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('caption');
            $table->integer('height')->unsigned();
            $table->integer('width')->unsigned();
            $table->integer('filesize')->unsigned();
            $table->timestamp('captured_at');
            $table->integer('album_id')->unsigned();
            $table->timestamps();
            $table->foreign('album_id')
                ->references('id')->on('gallery__albums')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('gallery__photos');
    }
}
