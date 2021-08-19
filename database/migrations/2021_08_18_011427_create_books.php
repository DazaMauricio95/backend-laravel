<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateBooks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id('IdBook');
            $table->string('nameBook', 80)->collation('utf8_spanish_ci');
            $table->string('author', 80)->collation('utf8_spanish_ci');
            $table->date('publicationDate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('Fkidcategory');
            $table->unsignedBigInteger('Fkidcreador');
            $table->tinyInteger('statusRent')->default('1');
            $table->tinyInteger('active')->default('1');
            $table->foreign('Fkidcategory')->references('IdCategory')->on('categories');
            $table->foreign('Fkidcreador')->references('id')->on('users');
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
        Schema::dropIfExists('books');
    }
}
