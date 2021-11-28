<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShortcodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shortcode', function (Blueprint $table) {
            $table->increments('id');
            $table->string('service_id');
            $table->string('product_id');
            $table->string('shortcode');
            $table->string('keyword');
            $table->string('service_name');
            $table->string('service_type');
            $table->string('type');
            $table->integer('share');
            $table->string('company_name');
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
        Schema::dropIfExists('shortcode');
    }
}
