<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shortcode extends Model
{
    protected $table="shortcode";

                  protected $fillable=[
                     'service_id',
                     'product_id',
                     'shortcode',
                     'keyword',
                     'service_name',
                     'service_type',
                     'type',
                     'share',
                     'company_name',
                  ];
}
