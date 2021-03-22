<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexConfProductMeasurements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conf_product_measurements', function (Blueprint $table) {
            $table->index(['product_id','measure_id'],'idx_products_measures','btree');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conf_product_measurements', function (Blueprint $table) {
            $table->dropIndex('idx_products_measures');
        });
    }
}
