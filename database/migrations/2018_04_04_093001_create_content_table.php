<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content', function (Blueprint $table) {
            $table->increments('id');
            $table->date('time');
            $table->string('service_id');
            $table->string('shortcode');
            $table->string('keyword');
            $table->string('product_id');
            $table->string('service_name');
            $table->string('service_type');
            $table->string('type');
            $table->string('company_name');
            $table->integer('share');
            $table->float('total_revenue', 8, 2);
            $table->float('vat', 8, 2);
            $table->float('miaki_revenue', 8, 2);
            $table->integer('order_number');
            $table->float('order_revenue', 8, 2);
            $table->integer('reorder_number');
            $table->float('reorder_revenue', 8, 2);
            $table->integer('on_demanded_number');
            $table->float('on_demanded_revenue', 8, 2);
            $table->float('third_party_revenue', 8, 2);
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
        Schema::dropIfExists('content');
    }
}
