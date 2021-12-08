<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFakeBillDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fake_bill_details', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->nullable();
            $table->string('category')->nullable();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->double('unit_price')->nullable();
            $table->integer('quantity')->nullable();
            $table->double('selling_price')->nullable();
            $table->tinyInteger('status')->default('0');
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
        Schema::dropIfExists('fake_bill_details');
    }
}
