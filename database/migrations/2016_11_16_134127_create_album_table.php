<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('albums', function (Blueprint $table) {
          $table->increments('id');
          $table->string("name");
          $table->text("description");
          $table->string("slug");

          $table->integer("user_id")->unisgned();
          $table->foreign("user_id")->references("id")->on("users");

          $table->timestamps();
          $table->softDeletes();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("albums");
    }
}
