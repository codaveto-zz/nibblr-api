<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDinnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dinners', function (Blueprint $table) {
            $table->id();
            $table->string( 'title' );
            $table->string( 'description' );
            $table->integer( 'max_guests' );
            $table->dateTime( 'start_time' );
            $table->dateTime( 'end_time' );
            $table->integer( 'user_id' );
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
        Schema::dropIfExists('dinners');
    }
}
