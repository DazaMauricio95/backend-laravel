<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {  
            $table->id();
            $table->string('name',80)->collation('utf8_spanish_ci');
            $table->string('lastname',80)->collation('utf8_spanish_ci');  
            $table->string('email')->collation('utf8_spanish_ci');  
            $table->string('password')->collation('utf8_spanish_ci');  
            $table->string('photo')->default('')->collation('utf8_spanish_ci');
            $table->string('role', 20)->collation('utf8_spanish_ci');
            $table->tinyInteger('active')->default('0');
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
        Schema::dropIfExists('users');
    }
}
