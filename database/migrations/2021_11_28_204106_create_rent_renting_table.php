<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentRentingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_rating', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rent_book_id');
            $table->foreign('rent_book_id')->references('id')->on('rent_books');
            $table->integer('rating_count');
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
        Schema::dropIfExists('rent_renting');
    }
}
