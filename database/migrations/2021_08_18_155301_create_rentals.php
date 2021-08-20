<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateRentals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id('IdRent');
            $table->unsignedBigInteger('Fkidbook');
            $table->unsignedBigInteger('Fkiduser');
            $table->date('rentDate');
            $table->date('returnDate');
            $table->tinyInteger('statusRent')->default('1');  
            $table->foreign('Fkidbook')->references('IdBook')->on('books');
            $table->foreign('Fkiduser')->references('id')->on('users');
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
        Schema::dropIfExists('rentals');
    }
}
