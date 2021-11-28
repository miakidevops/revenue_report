<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Active_subscriber extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'tbl_active_subscriber';
}
