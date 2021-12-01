<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Users extends Migration
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
            $table->string('userRole')->nullable();
            $table->string('name')->nullable();
            $table->string('email',)->unique();
            $table->string('password');
            $table->string('shopName')->nullable();
            $table->string('number')->nullable();
            $table->string('address')->nullable();
            $table->string('arabic_shopName')->nullable();
            $table->string('arabic_number')->nullable();
            $table->string('arabic_address')->nullable();
            $table->string('profile')->nullable();
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
