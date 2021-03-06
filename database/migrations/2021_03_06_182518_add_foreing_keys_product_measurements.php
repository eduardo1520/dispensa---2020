<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeingKeysProductMeasurements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_measurements', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
        });

        Schema::table('product_measurements', function (Blueprint $table) {
            $table->foreignId('measure_id')->constrained('measures')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_measurements', function (Blueprint $table) {
            $table->dropForeign('product_measurements_product_id_foreign');
        });

        Schema::table('product_measurements', function (Blueprint $table) {
            $table->dropForeign('product_measurements_measure_id_foreign');
        });
    }
}
