<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('animal_type_id');
            $table->integer('hunger_count');
            $table->integer('hunger_system_min');
            $table->integer('hunger_user_min');
            $table->integer('hunger_danger_min');
            $table->integer('sleep_count');
            $table->integer('sleep_system_min');
            $table->integer('sleep_user_min');
            $table->integer('care_count');
            $table->integer('care_system_min');
            $table->integer('care_user_min');
            $table->integer('joy_user_min');
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
        Schema::dropIfExists('animals');
    }
}
