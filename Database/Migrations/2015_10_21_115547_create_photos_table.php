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
            $table->string('title')->nullable();
            $table->text('caption')->nullable();
            $table->integer('height')->unsigned()->nullable();
            $table->integer('width')->unsigned()->nullable();
            $table->integer('filesize')->unsigned()->nullable();
            $table->timestamp('captured_at')->nullable();
            $table->integer('album_id')->unsigned()->nullable();
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
