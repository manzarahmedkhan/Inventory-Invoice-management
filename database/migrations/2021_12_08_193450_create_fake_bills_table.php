<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFakeBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fake_bills', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->nullable();
            $table->date('date')->nullable();
            $table->double('vat_percent')->nullable();
            $table->double('vat_amount')->nullable();
            $table->double('discount_amount')->nullable();
            $table->double('total_amount')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_mobile')->nullable();
            $table->string('comments')->nullable();
            $table->tinyInteger('status')->default('0');
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('fake_bills');
    }
}
