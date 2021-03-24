<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTableConfProductMeasurements extends Migration
{
    public function up()
    {
        Schema::table('conf_product_measurements', function (Blueprint $table) {
            $table->rename('conf_product_measurements_quantities');
        });
    }

    public function down()
    {
        Schema::table('conf_product_measurements_quantities', function (Blueprint $table) {
            $table->rename('conf_product_measurements');
        });
    }
}
