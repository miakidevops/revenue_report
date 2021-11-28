<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ussd_session extends Model
{
    protected $connection = 'sqlsrv2';
    protected $table = 'tbl_ussd_session_new';
}
