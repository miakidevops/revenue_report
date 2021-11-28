<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bdapps_service_list extends Model
{
    protected $connection = 'sqlsrv2';
    protected $table = 'tbl_bdapps_service_list';
}
