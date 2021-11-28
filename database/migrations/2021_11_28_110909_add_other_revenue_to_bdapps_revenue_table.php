<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOtherRevenueToBdappsRevenueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bdapps_revenue', function (Blueprint $table) {
            $table->float('other_rev',8,2)->default(0)->after('mmlbd_rev');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bdapps_revenue', function (Blueprint $table) {
            $table->dropColumn('other_rev');
        });
    }
}
