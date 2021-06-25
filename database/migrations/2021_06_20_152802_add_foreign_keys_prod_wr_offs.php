<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysProdWrOffs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_write_offs', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
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
        Schema::table('product_write_offs', function (Blueprint $table) {
            $table->dropForeign('product_write_offs_user_id_foreign');
            $table->dropForeign('product_write_offs_product_id_foreign');
            $table->dropForeign('product_write_offs_category_id_foreign');
            $table->dropForeign('product_write_offs_measure_id_foreign');
        });
    }
}
