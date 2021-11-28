<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBdappsRevenueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bdapps_revenue', function (Blueprint $table) {
            $table->increments('id');
            $table->date('rev_date');
            $table->float('miaki_rev', 8, 2);
            $table->float('mmlbd_rev', 8, 2);
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
        Schema::dropIfExists('bdapps_revenue');
    }
}
