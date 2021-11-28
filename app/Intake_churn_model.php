<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intake_churn_model extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'tbl_intake_churn';
}
