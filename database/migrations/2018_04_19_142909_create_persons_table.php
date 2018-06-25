<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname');
            $table->string('slug')->unique;
            $table->string('middlename')->nullable();
            $table->string('middlename_second')->nullable();
            $table->string('middlename_third')->nullable();
            $table->string('middlename_fourth')->nullable();
            $table->string('lastname')->nullable();
            $table->string('lastneme_prefix')->nullable();
            $table->integer('sex')->nullable();
            $table->string('tall')->nullable();
            $table->date('birth_date')->nullable();
            $table->date('death_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('death_place')->nullable();
            $table->string('image')->nullable();
            $table->boolean('image_show')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->boolean('published')->nullable();
            $table->integer('views')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable();
            $table->text('text');
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
        Schema::dropIfExists('persons');
    }
}
