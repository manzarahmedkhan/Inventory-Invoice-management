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
            $table->string('email')->unique();
            $table->string('password');
            $table->string('shopName')->nullable();
            $table->string('number')->nullable();
            $table->string('address')->nullable();
            $table->string('description')->nullable();
            $table->string('CR_no')->nullable();
            $table->string('arabic_shopName')->nullable();
            $table->string('arabic_number')->nullable();
            $table->string('arabic_address')->nullable();
            $table->string('arabic_description')->nullable();
            $table->string('arabic_CR_no')->nullable();
            $table->string('profile')->nullable();
            $table->string('number_2')->nullable();
            $table->string('number_3')->nullable();
            $table->string('arabic_number_2')->nullable();
            $table->string('arabic_number_3')->nullable();
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
