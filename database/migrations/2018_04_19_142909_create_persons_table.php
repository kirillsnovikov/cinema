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
            $table->string('middlename')->nullable();
            $table->string('middlename_second')->nullable();
            $table->string('middlename_third')->nullable();
            $table->string('middlename_fourth')->nullable();
            $table->string('lastname')->nullable();
            $table->string('lastneme_prefix')->nullable();
            $table->string('slug')->unique();
            $table->integer('sex')->nullable();
            $table->decimal('tall', 5, 2)->nullable();
            $table->date('birth_date')->nullable();
            $table->date('death_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('death_place')->nullable();
            $table->string('image_name')->nullable();
            $table->string('image_ext')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->boolean('published')->nullable();
            $table->integer('views')->nullable();
            $table->integer('kp_id')->unique();
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable();
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
