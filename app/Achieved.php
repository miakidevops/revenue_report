<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Achieved extends Model
{
    protected $connection = 'aws_revenue_dashboard';
    protected $table="achieved";

                     protected $fillable=[
                        'category_id',
                        'date',
                        'achieved',
                     ];
}
