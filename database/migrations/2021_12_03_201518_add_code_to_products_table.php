<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodeToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
<<<<<<< HEAD
            $table->float('code')->after('category_id')->nullable();
=======
            $table->string('code')->after('category_id')->nullable();
>>>>>>> ad7fa2c05c2fd6da28f37e5f77ec3f9e878c8405
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
}
